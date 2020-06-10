<div class="row" style="justify-content: center;">
    <h1>My TODO List</h1>
</div>
<form action="{{route('task.store')}}" method="POST" class="row" style="position:relative">
    {{ csrf_field() }} 
    <div class="col-lg-8 col-sm-12 row">
        <input type="text" name="content" class="add__text col-12" placeholder="What do you want to do?" value="{{ old('content') }}">
    </div>
    <input type="date" name="due_date" class="add__date col-lg-3 col-sm-6">
    <button class="btn btn-secondary col-1" type="submit">Add</button>
</form>
<div class="row">
    @error('content')
        <p style="margin-bottom: 0;" class="text-danger">{{$message}}</p>
    @enderror
    @error('due_date')
        <p style="margin-bottom: 0;" class="text-danger">{{$message}}</p>
    @enderror
</div>
<div class="d-flex justify-content-center mt-4 mb-4">
    <div style="height: 5px; background-color: black;" class="col-8"></div>
</div>

