<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
    @if(auth()->user())
        <a class="navbar-brand" href="{{ route('cars.showAll') }}">Main 🚗</a>
        @endif  
        <div class="d-flex gap-2">
            @auth
                @if(auth()->user()->isAdmin())
                    <a class="btn btn-success btn-sm" href="{{ route('admin.cars.create') }}">Add 🆕 Car</a>
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.brands.index') }}">Brands 🔖</a>
                    <a class="btn btn-warning btn-sm" href="{{ route('admin.cars.showTrashCars') }}">Trash 🗑️</a>
                @endif  
                <a href="{{ route('cars.profile') }}" class="btn btn-primary btn-sm">
                    Profile 👤🚪
                </a>
            @else
                <a class="btn btn-primary btn-sm" href="{{ route('auth.session.store') }}">Login 🔑</a>
                <a class="btn btn-secondary btn-sm" href="{{ route('auth.register.store') }}">Register 📝</a>
            @endauth
        </div>
    </div>
</nav>