@extends('layouts.app')
@section('content')
        <div class="content" id="add_task">
            <template>
                <task-form></task-form>  
            
            </template>
            
        </div>
        <script src="{{ asset('js/addtask.js') }}"></script>
    
@endsection
