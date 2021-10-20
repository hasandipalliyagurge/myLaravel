<div class="form-group">
    <label for="title">Title</label>
    <input id="title" type="text" name="title" class="form-control" value="{{ old('title',optional( $post ?? null)->title) }}">
</div>
 @error('title')
    <div class="alert alert-danger">{{$message}}</div>
 @enderror
 <div class="form-group">
    <label for="content">Content</label>
    <textarea id="content" name="content"  class="form-control">{{ old('content', optional($post ?? null)->content) }}</textarea>
</div>
 @error('content')
    <div  class="alert alert-danger">{{$message}}</div>
 @enderror
 @if($errors->any())
    <div class="mb-3">
        <ul>
            @foreach($errors->all() as $error)
                <li  class="list-group-item list-group-item-danger">{{ $error }}</li>
            @endforeach    
        </ul>
    </div>
 @endif