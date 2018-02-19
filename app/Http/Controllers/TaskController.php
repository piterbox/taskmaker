<?php 
namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;

class TaskController extends Controller
{
	


	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    /**
     * Show main page.
     *
     * @return view
     */
	public function index()
	{
		return view('welcome');
	}

	/**
     * Get tasks from DB to ajax request.
     *
     * @return json object
     */
	public function gettasks()
	{
		$tasks = Task::select('*')->where('user_id', Auth::id())->whereNotIn('state',['done'])->get()->toArray();
		return response()->json($tasks, 200);
	}

	/**
     * Show creating task page.
     *
     * @return view
     */
	public function create()
	{
		return view('add');
	}

	/**
     * Create a new instance of task and save to DB.
     *
     * @return json object
     */
	public function add(Request $request)
	{
		//validation request data
		$validatedData = $request->validate([
        'name' => 'required|max:120',
        'description' => 'required',
        'time' => 'required|numeric'
    	]);
		//creating new instance task and filling it request data 
		$task = new Task;
		$task->name = strip_tags($request->input('name'));
		$task->time = $request->input('time');
		$task->description = strip_tags($request->input('description'));
		$task->user_id = Auth::id();
		//saving to DB
		if($task->save()){
			return response()->json(['task' => $task], 201);
		}
		return response()->json(['error' => 'Something was wrong'], 200);
	}

	/**
     * Show editing task page
     *
     * @return view
     */
	public function edit($id)
	{
		
		return view('add');
	}

	/**
     * Get task from DB to ajax request.
     *
     * @return view
     */
	public function gettask($id)
	{
		$task = Task::where(['id' => $id, 'user_id' => Auth::id()])->first();
		
		return response()->json($task, 200);
	}

	/**
     * Updating task in DB.
     *
     * @return json object
     */
	public function update(Request $request, $id)
	{
		//validation request data
		$validatedData = $request->validate([
        'name' => 'required|max:120',
        'description' => 'required',
        'time' => 'required|numeric'
    	]);
		//get object task from DB for id
		$task = Task::get()->where('id', $id)->first();
		//if task not found in DB create new instance task
		if(null == $task ){
			$task = new Task();
			$task->name = strip_tags($request->input('name'));
			$task->time = $request->input('time');
			$task->description = $request->input('description');
			$task->user_id = Auth::id();
			$result=$task->save();
		}//if found task in DB then filling task new request data
		else{
			$data = $request->except('active');
			$task->name = strip_tags($request->input('name'));
			$task->time = $request->input('time');
			$task->description = strip_tags($request->input('description'));
			if($request->input('state') != null){
				$task->state = $request->input('state');
			}
			if($request->input('seconds') != null){
				$task->seconds = $request->input('seconds');
			}
			if($request->input('time_left') != null){
				$task->time_left = $request->input('time_left');
			}
			$result=$task->update();
		}
		//sending ajax response
		if($result){
			return response()->json(['task' => $task], 201);
		}
		return response()->json(['error' => 'Something was wrong'], 200);
	}

	/**
     * Delete task from DB for id.
     *
     * @return void
     */
	public function delete($id)
	{
		$task=Task::where('id', $id)->first();
		$task->delete();
	}

	/**
     * Show page information.
     *
     * @return view
     */
	public function information()
	{
		return view('information');
	}

	/**
     * Get information about tasks and tasks time to ajax request.
     *
     * @return json object
     */
	public function getInfo(Request $request)
	{
		//check input data if exists (input period to and input period from)
		if($request->input('from') != null && !empty($request->input('from'))){
			$from = new \DateTime($request->input('from'));
		}
		else{
			$from =  new \DateTime('2000-01-01');
		}

		if($request->input('to') != null && !empty($request->input('to'))){
			$to = new \DateTime($request->input('to'));
			$to->modify('+1 day');
		}
		else{
			$to = new \DateTime('2200-01-01');;
		}

		//get information from DB for date between input data
		$data = Task::select('*')->where([['user_id', Auth::id()],['created_at','>', $from],['created_at','<', $to]])->get()->toArray();

		//create new array for response and fill it data
		$tasks = array();
		$i = 0;
		if($data != null){
			foreach ($data as $task) {
				$tasks[$i]['name']=$task['name'];
				$tasks[$i]['description']=$task['description'];
				$tasks[$i]['state']=$task['state'];
				$tasks[$i]['time']=$task['time'];
				$tasks[$i]['seconds']=$task['seconds'];
				$date = new \DateTime($task['created_at']);
				$tasks[$i]['created'] = $date->format('H:i:s d-m-Y');
				if($task['seconds'] != 0 && $task['state'] != 'new'){
					$tasks[$i]['used_time'] = $task['time'] - $task['time_left']-1;
				}
				else{
					$tasks[$i]['used_time'] = 0;
				}
				
				$i++;
			}
		}
		return response()->json($tasks, 200);
	}

}
