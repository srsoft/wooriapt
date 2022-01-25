<?php

namespace App\Http\Controllers;

use App\Http\Requests\LetterRequest;
use App\Http\Resources\LetterResource;
use App\Models\Favorite;
use App\Models\Letter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\LetterCollection;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function infinite(Request $request)
    {
        $posts = Letter::orderBy('id', 'desc');
        return $posts->paginate(10);
    }

    public function index(Request $request)
    {
        $allLetters = Letter::with(['user'])->get()->sortByDesc('id');
        $filteredLetterss = LetterResource::collection($allLetters);
        return $filteredLetterss;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LetterRequest $request)
    {
//        if($request->file('letter_thumbnail')) {
//            $pathToFile = $request->file('letter_thumbnail')->store('letters', 'public');
//        } else {
//            $pathToFile = '';
//        }

        if ($request->hasfile('letter_thumbnail')) {
            $images = $request->file('letter_thumbnail');

            foreach($images as $image) {
                $path_array[] = $image->store('letters', 'public');
            }
            $pathToFile = implode(',',$path_array);
        } else {
            $pathToFile = '';
        }

        $newLetter = Letter::create([
            'user_id' => $request->user_id,
            'contents' => $request->contents,
            'animal_name' => $request->animal_name,
            'letter_thumbnail' => $pathToFile,
            'letter_favorites_count' => $request->letter_favorites_count,
            'letter_comments_count' => $request->letter_comments_count,
        ]);

        return new LetterResource($newLetter);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
//        $filteredLetters = new LetterResource($letter);
//        return $filteredLetters;
//        return $request->user_id;

        $body = Letter::with(['favorite' => function ($query) use ($request) { $query->where('user_id', $request->user_id); }])->find($id);
        $param = [
            "body" => $body,
            "prev" => DB::table("letters")->select('id', 'user_id', 'animal_name')->where('id', '>', $id)->where('animal_name', $body->animal_name)->first(),
            "next" => DB::table("letters")->select('id', 'user_id', 'animal_name')->where('id', '<', $id)->where('animal_name', $body->animal_name)->orderByDesc('id')->first(),
        ];

        return new LetterResource($param);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LetterRequest $request, Letter $Letter)
    {
        $Letter->update($request->all()); // 외부에서 가저온 데이터를 업데이트 한다.
        $updatedLetter = new LetterResource($Letter);

        // 기존 데이터를 불러온다. & 이미지 업데이트 & letter_thumbnail 수정
        $filteredLetters = new LetterResource($Letter);
        if ($request->file('letter_thumbnail')) {
            $pathToFile = $request->file('letter_thumbnail')->store('letters', 'public');
            $Letter::where('id', $filteredLetters->id)->update(['letter_thumbnail' => $pathToFile]);
        }

        return $updatedLetter;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Letter $Letter)
    {

        // 편지와 연결된 즐겨찾기 삭제
        DB::table('favorites')->where('letter_id', $Letter->id)->delete();

        // 편지와 연결된 댓글 삭제
        DB::table('comments')->where('parent_id', $Letter->id)->delete();

        $Letter->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
