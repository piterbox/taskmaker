@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Cabinet</h3></div>
                @if(session('success'))
                <div class="alert alert-success" role="alert" v-if="success" v-model="success">
                    {{session('success')}}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger" role="alert" v-if="error404" v-model="error404">
                    {{session('error')}} 
                </div>
                    
                @endif
                <div style="padding: 10px;">
                    <form action="{{route('cabinetupdate')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-row">
                        <p>Avatar</p>
                        <?php if($user->avatar != null):?>
                        <div style="width: 100px; height: 100px; overflow: hidden;">
                            <img src="{{asset('/images/'.$user->avatar)}}" style="width: 100%;">
                        </div>
                        <?php endif;?>
                        <div class="form-group">
                            <label for="avatar" >Upload avatar:</label>
                            <input type="file" name="avatar" id="avatar" class="form-control">
                        </div>
                        <br>
                        
                        <div class="form-group">
                            <label for="name" >User name:</label>
                            <input type="text" name="name" id="name" value="{{$user->name}}" class="form-control"/>
                        </div>
                        <br>
                        
                        <div>
                            <!-- <button class="btn btn-primary"/>Save</button> -->
                        </div>
                        </div>
                        <input type="submit" name="" value="Save">
                    </form>
                    @if(session('success'))
                    <div class="alert alert-success" role="alert" v-if="success" v-model="success">
                        {{session('success')}}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger" role="alert" v-if="error404" v-model="error404">
                        {{session('error')}} 
                    </div>
                        
                    @endif
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
