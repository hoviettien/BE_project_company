import weaviate
from weaviate.auth import AuthApiKey
import json
import google.generativeai as genai
from dotenv import load_dotenv

# =============================
# 🔑 Load ENV
# =============================
load_dotenv()

WEAVIATE_URL = ""
WEAVIATE_API_KEY = ""
GEMINI_API_KEY = ""

# =============================
# 🌐 Weaviate Client
# =============================
client = weaviate.Client(
    url=WEAVIATE_URL,
    auth_client_secret=AuthApiKey(api_key=WEAVIATE_API_KEY)
)

# =============================
# 🧠 Gemini Embedding Model
# =============================
genai.configure(api_key=GEMINI_API_KEY)
embedding_model = "models/embedding-001"

def embed_text(text: str):
    if not text:
        return [0.0] * 768
    try:
        result = genai.embed_content(model=embedding_model, content=text)
        return result.get("embedding", [0.0] * 768)
    except Exception as e:
        print(f"⚠️ Embedding error: {e}")
        return [0.0] * 768

# =============================
# 📚 Schema
# =============================
class_name = "Document"

if client.schema.exists(class_name):
    client.schema.delete_class(class_name)

document_schema = {
    "class": class_name,
    "properties": [
        {"name": "type", "dataType": ["text"]},
        {"name": "title", "dataType": ["text"]},
        {"name": "content", "dataType": ["text"]},
        {"name": "image", "dataType": ["text"]},
        {"name": "extra", "dataType": ["text"]},
    ],
    "vectorizer": "none"
}

client.schema.create_class(document_schema)

# =============================
# 📂 Helper load JSON
# =============================
def load_json(path):
    with open(path, "r", encoding="utf-8") as f:
        return json.load(f)

# =============================
# 🚀 Import Helper cho partner/mentor/startup
# =============================
def import_data(data, dtype: str):
    for item in data:
        try:
            title = item.get("name") or item.get("title")
            content = (
                item.get("description")
                or item.get("detail")
                or item.get("content")
                or ""
            )

            if title and title not in content:
                content = f"{title}. {content}"

            vector = embed_text(content)

            extra = {k: v for k, v in item.items() if k not in ["name","title","description","detail","content","logo","image_url","image"]}

            client.data_object.create(
                {
                    "type": dtype,
                    "title": title,
                    "content": content,
                    "image": item.get("logo") or item.get("image_url") or item.get("image"),
                    "extra": json.dumps(extra, ensure_ascii=False)
                },
                class_name,
                vector=vector
            )
            print(f"✅ Imported {dtype}: {title}")
        except Exception as e:
            print(f"❌ Failed to import {dtype} {item.get('name') or item.get('title')}: {e}")

# =============================
# 🚀 Import Articles
# =============================
def import_articles(data):
    for item in data:
        try:
            title = item.get("title")
            content = item.get("content") or ""

            if title and title not in content:
                content = f"{title}. {content}"

            vector = embed_text(content)

            extra = {
                "id": item.get("id"),
                "link": item.get("link"),
                "date": item.get("date"),
                "category": item.get("category"),
                "event": item.get("event"),
                "images": item.get("images", [])
            }

            client.data_object.create(
                {
                    "type": "article",
                    "title": title,
                    "content": content,
                    "image": item.get("image"),
                    "extra": json.dumps(extra, ensure_ascii=False)
                },
                class_name,
                vector=vector
            )
            print(f"✅ Imported article: {title}")
        except Exception as e:
            print(f"❌ Failed to import article {item.get('title')}: {e}")

# =============================
# 🚀 Run Import All
# =============================
partners = load_json("../data/partners.json")
mentors = load_json("../data/mentor.json")
startups = load_json("../data/startups.json")
articles = load_json("../data/articles.json")

import_data(partners, "partner")
import_data(mentors, "mentor")
import_data(startups, "startup")
import_articles(articles)

print("🎯 Done importing all data")
