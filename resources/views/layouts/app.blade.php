<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Salt Pans') - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <style>
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        .font-elegant {
            font-family: 'Cormorant Garamond', serif;
        }
        .font-sans {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-[#1a1a1a] min-h-screen flex flex-col">
    <header class="bg-white border-b border-[#e5e5e5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-24">
                <div class="flex items-center">
                    <a href="{{ route('recipes.index') }}" class="text-2xl font-serif text-[#1a1a1a] hover:text-[#666] transition-colors tracking-tight">
                        <img src="/images/logo.jpg" alt="Salt Pans" class="h-8">
                    </a>
                </div>
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="lg:hidden p-2 text-[#1a1a1a] hover:text-[#666] transition-colors" aria-label="Toggle menu">
                    <svg id="menu-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-8">
                    @php
                        $categories = \App\Models\Category::all();
                    @endphp
                    @if($categories->count() > 0)
                        @foreach($categories as $category)
                            <a href="{{ route('categories.show', $category->slug) }}" 
                               class="text-sm font-sans font-light text-[#666] hover:text-[#1a1a1a] transition-colors uppercase tracking-wider relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-[#1a1a1a] hover:after:w-full after:transition-all">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    @endif
                    
                    <!-- Desktop Search -->
                    <form action="{{ route('recipes.search') }}" method="GET" class="flex items-center">
                        <div class="relative">
                            <input type="text" 
                                   name="q" 
                                   value="{{ request('q') }}"
                                   placeholder="Search recipes..." 
                                   class="pl-10 pr-4 py-2 text-sm font-sans font-light text-[#1a1a1a] border border-[#e5e5e5] focus:outline-none focus:border-[#1a1a1a] transition-colors w-48"
                                   autocomplete="off">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-[#999]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </form>
                </nav>
            </div>
            
            <!-- Mobile Navigation -->
            <nav id="mobile-menu" class="hidden lg:hidden pb-6 border-t border-[#e5e5e5] mt-4">
                @php
                    $categories = \App\Models\Category::all();
                @endphp
                
                <!-- Mobile Search -->
                <form action="{{ route('recipes.search') }}" method="GET" class="pt-4 pb-4">
                    <div class="relative">
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}"
                               placeholder="Search recipes..." 
                               class="w-full pl-10 pr-4 py-2 text-sm font-sans font-light text-[#1a1a1a] border border-[#e5e5e5] focus:outline-none focus:border-[#1a1a1a] transition-colors"
                               autocomplete="off">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-[#999]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </form>
                
                @if($categories->count() > 0)
                    <div class="flex flex-col space-y-4 pt-2">
                        @foreach($categories as $category)
                            <a href="{{ route('categories.show', $category->slug) }}" 
                               class="text-sm font-sans font-light text-[#666] hover:text-[#1a1a1a] transition-colors uppercase tracking-wider py-2">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </nav>
        </div>
    </header>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');
            
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                menuIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInsideMenu = mobileMenu.contains(event.target);
                const isClickOnButton = mobileMenuButton.contains(event.target);
                
                if (!isClickInsideMenu && !isClickOnButton && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                }
            });
        });
    </script>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-[#e5e5e5] mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <p class="text-center text-xs font-sans font-light text-[#999] uppercase tracking-wider">
                &copy; {{ date('Y') }} Salt Pans. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>

