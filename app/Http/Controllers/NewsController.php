<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Repository\NewsRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    private NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return new Response($this->newsRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreNewsRequest $request
     * @return Response
     */
    public function store(StoreNewsRequest $request): Response
    {
        try {
            $news = new News($request->all());
            $news->user_id = Auth::user()->id;
            $news->save();

            return new Response($news, 201);
        } catch (Exception $exception) {
            return new Response(['message' => $exception->getMessage()],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param News $news
     * @return Response
     */
    public function show(News $news): Response
    {
        return new Response($news);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateNewsRequest $request
     * @param News $news
     * @return Response
     */
    public function update(UpdateNewsRequest $request, News $news): Response
    {
        try {
            $news->update($request->all());

            return new Response($news, 200);
        } catch (Exception $exception) {
            return new Response(['message' => $exception->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News $news
     * @return Response
     */
    public function destroy(News $news): Response
    {
        $news->delete();

        return new Response('', 204);
    }
}
