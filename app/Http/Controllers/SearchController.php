<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Speaker;
use App\Models\Event;
use App\Models\Partner;
use App\Models\Article;

class SearchController extends Controller
{
    // Hàm bỏ dấu tiếng Việt
    private function removeAccents($str)
    {
        $str = strtolower($str);
        $unicode = [
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        ];
        foreach ($unicode as $nonAccent => $accent) {
            $str = preg_replace("/($accent)/i", $nonAccent, $str);
        }
        return $str;
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        // Search speakers
        $speakers = Speaker::where('name', 'LIKE', "%$query%")
            ->orWhere('title', 'LIKE', "%$query%")
            ->orWhere('organization', 'LIKE', "%$query%")
            ->get();

        // Search events
        $events = Event::where('title', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->get();

        // Search partners
        $partners = Partner::where('name', 'LIKE', "%$query%")
            ->get();

        // Search articles
        $articles = Article::where('title', 'LIKE', "%$query%")
            ->orWhere('content', 'LIKE', "%$query%")
            ->get();

        return response()->json([
            'speakers' => $speakers,
            'events' => $events,
            'partners' => $partners,
            'articles' => $articles,
        ]);
    }


}
