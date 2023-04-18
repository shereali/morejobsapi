<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Services\HelperService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        try {
            $currentRoute = $request->route()[1]['as'];
            $map = [
                'admission' => [
                    'type' => 1,
                    'url' => 'admission',
                    'title' => 'Admission'
                ],
                'events' => [
                    'type' => 2,
                    'url' => 'events',
                    'title' => 'Events/Fair'
                ],
                'scholarship' => [
                    'type' => 3,
                    'url' => 'scholarship',
                    'title' => 'Scholarship'
                ],
                'articles' => [
                    'type' => 4,
                    'url' => 'articles',
                    'title' => 'Articles'
                ]
            ];
            $type = $map[$currentRoute];

            $data = Blog::where('status', 1)
                ->where('type', $type['type'])
                ->orderBy('created_at', 'DESC')
                ->paginate(HelperService::getMAxItemLimit(10));

            if ($type['type'] == 4) {
                return view('pages.blogs.articles', compact('data', 'type'));
            }

            return view('pages.blogs.index', compact('data', 'type'));
        } catch (\Exception $e) {
            return 'something went wrong' . $e->getMessage();
        }
    }

    public function show($id, Request $request)
    {
        $currentRoute = $request->route()[1]['as'];
        $map = [
            'admissionDetails' => [
                'type' => 1,
                'url' => 'admissionDetails',
                'title' => 'Admission'
            ],
            'eventsDetails' => [
                'type' => 2,
                'url' => 'eventsDetails',
                'title' => 'Events/Fair'
            ],
            'scholarshipDetails' => [
                'type' => 3,
                'url' => 'scholarshipDetails',
                'title' => 'Scholarship'
            ],
            'articlesDetails' => [
                'type' => 4,
                'url' => 'articles',
                'title' => 'Articles'
            ]
        ];
        $type = $map[$currentRoute];
        $data = Blog::findOrFail($id);

        if ($type['type'] == 4) {
            $data['article_list'] = Blog::select('id', 'title')->where('status', 1)
                ->where('type', $type['type'])
                ->orderBy('created_at', 'DESC')
                ->paginate(HelperService::getMAxItemLimit(10));

            return view('pages.blogs.article-details', compact('data', 'type'));
        }

        return view('pages.blogs.show', compact('data', 'type'));
    }
}
