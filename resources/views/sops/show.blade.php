<x-app-layout>

<div class="container mt-4 shadow py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mb-4">
                <a href="{{ route('sops.index') }}" class="btn btn-outline-secondary">
                    Back to SOPs
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        Standard Operating Procedure
                    </h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('sops.edit', $sop) }}" class="btn btn-light btn-sm"> 
                            Edit
                        </a>
                        <form action="{{ route('sops.destroy', $sop) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this SOP?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body p-4">
                   
                    <div class="mb-4">
                        <h2 class="mb-3">{{ $sop->title }}</h2>
                        
                       
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @if($sop->category)
                                <span class="badge bg-primary">{{ $sop->category }}</span>
                            @endif
                            
                            @if($sop->difficulty)
                                <span class="badge {{ $sop->difficulty == 'Easy' ? 'bg-success' : ($sop->difficulty == 'Moderate' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $sop->difficulty }}
                                </span>
                            @endif
                            
                            @if($sop->estimated_time)
                                <span class="badge bg-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                    </svg>
                                    {{ $sop->estimated_time }} min
                                </span>
                            @endif
                            
                            <span class="badge {{ $sop->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $sop->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>

                  
                    @if($sop->description)
                        <div class="mb-4">
                            <h5 class="fw-semibold mb-2">Description</h5>
                            <p class="text-muted">{{ $sop->description }}</p>
                        </div>
                    @endif

                   
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-3">Step-by-Step Instructions</h5>
                        <div class="bg-light p-4 rounded">
                            <div style="white-space: pre-wrap; line-height: 1.8;">{!!html_entity_decode($sop->steps)!!}</div>
                        </div>
                    </div>

                    
                    @if($sop->tags)
                        <div class="mb-4">
                            <h5 class="fw-semibold mb-2">Tags</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(explode(',', $sop->tags) as $tag)
                                    <span class="badge bg-secondary">{{ trim($tag) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                 
                    <div class="border-top pt-3 mt-4">
                        <div class="row text-muted small">
                            <div class="col-md-6">
                                <strong>Created:</strong> {{ $sop->created_at->format('F j, Y \a\t g:i A') }}
                            </div>
                            <div class="col-md-6">
                                <strong>Last Updated:</strong> {{ $sop->updated_at->format('F j, Y \a\t g:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>