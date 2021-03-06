<div class="card col-sm-6 col-md-4" style="width: 40rem;">
    @if (isset($item->image) && $item->image)
        <div class="thumbnail">
            <img class="card-img-top" style="width: 36rem;" src="{{ asset('/images/items/' . $item->id . '/' . $item->image) }}" alt="Card image cap">
        </div>
    @endif
</div>

<!-- Name Field -->
<div class="form-group col-sm-12">
    {{ Form::label('name', 'Name:') }}
    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => "Enter Item's Name"]) }}
</div>

<!-- Price Field -->
<div class="form-group col-sm-12">
    {{ Form::label('price', 'Price:') }}
    {{ Form::number('price', null, ['class' => 'form-control', 'placeholder' => "Enter Item's price in eur"]) }}
</div>

<!-- Image Field -->
<div class="form-group col-sm-12">
    {{ Form::label('image', 'Image of item (5MB max):') }}
    {{ Form::file('image', null, ['class' => 'form-control']) }}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
    <a href="{{ route('items.index') }}" class="btn btn-default">Cancel</a>
</div>
