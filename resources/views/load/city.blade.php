

    @foreach ($cities as $city)
    <li data-value="{{ $city->id }}" class="option focus selected">{{ $city->title }}</li>
    @endforeach
