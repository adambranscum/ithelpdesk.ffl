<x-app-layout>

<div class="container shadow mt-4 py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-6 fw-bold">Standard Operating Procedures</h1>
            <p class="text-muted">Knowledge base and step-by-step guides for IT support</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('sops.create') }}" class="btn btn-primary">
                Add SOP
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
   <!-- <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total SOPs</h6>
                    <h2 class="mb-0 fw-bold">{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Categories</h6>
                    <h2 class="mb-0 fw-bold text-primary">{{ $stats['categories'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total Views</h6>
                    <h2 class="mb-0 fw-bold text-success">{{ number_format($stats['total_views']) }}</h2>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Search and Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('sops.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search SOPs..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Difficulty</label>
                    <select name="difficulty" class="form-select">
                        <option value="">All Levels</option>
                        @foreach($difficulties as $difficulty)
                            <option value="{{ $difficulty }}" {{ request('difficulty') == $difficulty ? 'selected' : '' }}>{{ $difficulty }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sort By</label>
                    <select name="sort" class="form-select">
                        <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Most Recent</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <a href="{{ route('sops.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- SOPs Grid -->
    @if($sops->count() > 0)
    <div class="row g-4 mb-4">
        @foreach($sops as $sop)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <!-- Category Badge -->
                    @if($sop->category)
                    <span class="badge bg-primary mb-2">{{ $sop->category }}</span>
                    @endif
                    
                    <!-- Title -->
                    <h5 class="card-title">
                        <a href="{{ route('sops.show', $sop) }}" class="text-decoration-none text-dark">
                            {{ $sop->title }}
                        </a>
                    </h5>
                    
                    <!-- Description -->
                    @if($sop->description)
                    <p class="card-text text-muted small">
                        {{ Str::limit($sop->description, 100) }}
                    </p>
                    @endif
                    
                    <!-- Meta Info -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        @if($sop->difficulty)
                        <span class="badge 
                            @if($sop->difficulty == 'Easy') bg-success
                            @elseif($sop->difficulty == 'Moderate') bg-warning text-dark
                            @else bg-danger
                            @endif">
                            {{ $sop->difficulty }}
                        </span>
                        @endif
                        
                        @if($sop->estimated_time)
                        <small class="text-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                            </svg>
                            {{ $sop->estimated_time }} min
                        </small>
                        @endif
                        
                        <small class="text-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                            {{ $sop->view_count }} views
                        </small>
                    </div>
                    
                    <!-- Tags -->
                    @if($sop->tags)
                    <div class="mb-3">
                        @foreach($sop->tags_array as $tag)
                        <span class="badge bg-light text-dark me-1">{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif
                    
                    <!-- Actions -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('sops.show', $sop) }}" class="btn btn-sm btn-primary flex-fill">
                            View Guide
                        </a>
                        <a href="{{ route('sops.edit', $sop) }}" class="btn btn-sm btn-outline-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $sops->links() }}
    </div>
    @else
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <h4 class="text-muted">No SOPs Found</h4>
            <p class="text-muted">Start building your knowledge base by creating your first Standard Operating Procedure.</p>
            <a href="{{ route('sops.create') }}" class="btn btn-primary mt-3">
                Create First SOP
            </a>
        </div>
    </div>
    @endif
</div>

</x-app-layout>