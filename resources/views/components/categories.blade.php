<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Categories
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        @foreach ($categories as $category)
        <a class="dropdown-item" href="{{ route('category', $category) }}">
            <span>{{ $category->name}} ({{ $category->products()->count() }})</span>
        </a>
    @endforeach
    </div>
</li>
