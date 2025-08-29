# Database Setup (MySQL & Weaviate)
#  Project Setup Guide

This project uses **2 databases**:  
- **MySQL** – for relational data  
- **Weaviate** – for vector search and semantic queries  

Follow the steps below to set up your environment.

---

## 1 MySQL Setup

### Install MySQL
- Option 1: Install [MySQL Community Server](https://dev.mysql.com/downloads/).  
- Option 2: Use Docker:
  ```bash
  docker run --name mysql-db     -e MYSQL_ROOT_PASSWORD=123456     -e MYSQL_DATABASE=project_db     -p 3306:3306     -d mysql:8.0
  ```

### Configure Connection
Create `.env` file in project root:
```env
DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASSWORD=123456
DB_NAME=project_db
```

### Initialize Database
Run migration or SQL script:
```bash
mysql -u root -p project_db < db/migrations/init.sql
```

---

## 2 Weaviate Setup

### Install Weaviate with Docker Compose
Create a file `docker-compose.yml`:
```yaml
version: '3.4'
services:
  weaviate:
    image: semitechnologies/weaviate:latest
    ports:
      - "8080:8080"
    environment:
      QUERY_DEFAULTS_LIMIT: 25
      AUTHENTICATION_ANONYMOUS_ACCESS_ENABLED: 'true'
      PERSISTENCE_DATA_PATH: './data'
```

Start Weaviate:
```bash
docker-compose up -d
```

### Check Weaviate
Open [http://localhost:8080/v1/graphql](http://localhost:8080/v1/graphql) in your browser.  
Try a GraphQL query:
```graphql
{
  Get {
    Article {
      title
      url
    }
  }
}
```

### Configure Connection
Add this to `.env`:
```env
WEAVIATE_HOST=http://localhost:8080
```

---

## 3 Usage Notes
- Use **MySQL** for structured/relational data.  
- Use **Weaviate** for semantic search & vector data.  
- When adding new data (e.g., an article), insert into MySQL **and** index vectors in Weaviate.

---


