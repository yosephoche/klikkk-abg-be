<?php

namespace App\Http\Controllers\Api\User\Pengajuan;

use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\verifikasiQnA;
use App\Models\QnA;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Traits\forumTrait;
use App\Http\Resources\QnAResource;
use App\Notifications\questionPostNotification;
use App\Notifications\answerPostNotification;
use App\Notifications\replyAnswerNotification;
use Illuminate\Support\Facades\Notification;



class qnaController extends Controller
{
    use forumTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = QnA::orderBy('id','desc')->where('user_id',Auth::user()->id)->paginate(5);
        $response = QnAResource::collection($data);
        return $this->collectionHttpResponse($response,$data);
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
    public function store(Request $request)
    {
        $question = new QnA;
        $question->question = $request->question;
        $question->user_id = Auth::user()->id;
        $question->save();
        Mail::to($question->user->email)->queue(new verifikasiQnA($question));

        $staff = User::whereHas('roles', function($query){
            $query->where('name','staf_teknis');
        })->get();

        Notification::send($staff, new questionPostNotification($question));        
        
        return dtcApiResponse(200,null,'Pertanyaan Sudah Di Simpan');
    }


    /** 
    * Store Answer for the question
    * @param int $id
    * @return \Illuminate\Http\Response
    *
    */
    public function answer(Request $request,$id)
    {
        $answer = new Answer;
        $answer->answer = $request->answer;
        $answer->user()->associate(Auth::user()->id);
        $answer->qna_id = $id;
        
        $question = QnA::find($id);
        $latest = $question->answers->last();

        if(!isset($latest))
        {
            $user = User::find($question->user->id);
        } else {
            $user = User::find($latest->user->id);
        }
        
        $role = $user->roles->where('name','staf_teknis')->first();
        if(isset($role))
        {
            $staff = User::whereHas('roles', function($query){
                $query->where('name','staf_teknis');
            })->get();

            $question->answers()->save($answer);
            Notification::send($staff, new answerPostNotification($answer,$question));        
        } else {
            $question->answers()->save($answer);
            Notification::send($question->user, new answerPostNotification($answer,$question));        
        }       

        return dtcApiResponse(200,null,'Pertanyaan Sudah Di Balas');
    }


    public function reply(Request $request,$id)
    {
        $answer = new Answer;
        $answer->answer = $request->reply;
        $answer->user()->associate(Auth::user()->id);
        $answer->parent_id = $id;

        $question = QnA::find($request->questionId);

        $question->answers()->save($answer);

        Notification::send($question->user, new answerPostNotification($answer,$question));                
        return dtcApiResponse(200,null,'Berhasil Melakukan Balasan');

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = QnA::find($id);
        if(isset($data))
        {
            $response = new QnAResource($data);
            return $this->singleHttpResponse($data,$response);
        } else {
            return $this->notFound();
        }
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = QnA::find($id);
        if(isset($data))
        {
            if($data->user_id == Auth::user()->id)
            {
                $answers = Answer::where('qna_id', $data->id)->get();
                foreach($answers as $answer)
                {
                    $answer->deleteRelatedData();
                }
                $data->deleteRelatedAnswer();
                $data->delete();
                return dtcApiResponse(200,null,'Pertanyaan Dihapus');
            }

        }
        
    }
}
