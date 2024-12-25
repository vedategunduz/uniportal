<select name="{{ $name }}" id="{{ $key }}">
    @foreach ($options as $option)
        <option value="{{ encrypt($option->id) }}">{{ $option->text }}</option>
    @endforeach
</select>
