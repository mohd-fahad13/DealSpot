@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* --- THEME ENGINE --- */
:root {
    --bg-body: #020617;
    --bg-surface: #0f172a;
    --glass-bg: rgba(30, 41, 59, 0.45);
    --glass-border: rgba(255, 255, 255, 0.08);
    --text-main: #f8fafc;
    --text-muted: #94a3b8;
    --primary: #f59e0b; /* Amber - High Contrast for Deals */
    --accent: #10b981;  /* Emerald for Valid/Success */
    --danger: #ef4444;  /* Red for Expired/Delete */
    --indigo: #6366f1;  /* Blue for Secondary Actions */
}

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background-color: var(--bg-body);
    color: var(--text-main);
    background-image: 
        radial-gradient(at 0% 0%, rgba(245, 158, 11, 0.1) 0px, transparent 50%),
        radial-gradient(at 100% 100%, rgba(99, 102, 241, 0.1) 0px, transparent 50%);
    min-height: 100vh;
}

/* --- ANIMATIONS --- */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

.animate-fade-up { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

/* --- LAYOUT --- */
.deal-container {
    max-width: 1100px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

/* --- HEADER / HERO SECTION --- */
.deal-hero {
    position: relative;
    border-radius: 32px;
    overflow: hidden;
    background: var(--bg-surface);
    border: 1px solid var(--glass-border);
    margin-bottom: 2rem;
    display: flex;
    flex-direction: row;
}

.hero-image-wrapper {
    width: 45%;
    position: relative;
    min-height: 400px;
}

.hero-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #1e293b, #0f172a);
    font-size: 5rem;
    color: var(--primary);
}

.hero-content {
    width: 55%;
    padding: 3.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* --- BENTO GRID TILES --- */
.bento-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

.glass-card {
    background: var(--glass-bg);
    backdrop-filter: blur(12px);
    border: 1px solid var(--glass-border);
    border-radius: 24px;
    padding: 2rem;
    transition: transform 0.3s ease, border-color 0.3s ease;
}

.glass-card:hover {
    border-color: rgba(245, 158, 11, 0.3);
}

/* --- SPECIAL COMPONENTS --- */
.discount-badge-large {
    display: inline-flex;
    align-items: center;
    background: rgba(245, 158, 11, 0.15);
    color: var(--primary);
    padding: 0.5rem 1.25rem;
    border-radius: 50px;
    font-weight: 800;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1rem;
}

.status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    font-weight: 700;
    padding: 6px 16px;
    border-radius: 50px;
}

.status-active { background: rgba(16, 185, 129, 0.15); color: var(--accent); }
.status-expired { background: rgba(239, 68, 68, 0.15); color: var(--danger); }

.promo-tag {
    background: var(--bg-body);
    border: 2px dashed var(--primary);
    padding: 1rem;
    border-radius: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.promo-code-text {
    font-family: 'Monaco', 'Consolas', monospace;
    font-weight: 800;
    font-size: 1.4rem;
    color: var(--primary);
}

/* --- BUTTONS --- */
.btn-modern {
    padding: 0.8rem 1.8rem;
    border-radius: 14px;
    font-weight: 700;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-primary-modern {
    background: linear-gradient(135deg, var(--indigo), #818cf8);
    color: white;
    border: none;
    box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
}

.btn-primary-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px -5px rgba(99, 102, 241, 0.6);
    color: white;
}

.btn-danger-outline {
    background: transparent;
    border: 1px solid rgba(239, 68, 68, 0.4);
    color: var(--danger);
}

.btn-danger-outline:hover {
    background: var(--danger);
    color: white;
}

/* --- RESPONSIVE --- */
@media (max-width: 992px) {
    .deal-hero { flex-direction: column; }
    .hero-image-wrapper, .hero-content { width: 100%; }
    .hero-image-wrapper { min-height: 300px; }
    .bento-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 768px) {
    .bento-grid { grid-template-columns: 1fr; }
    .hero-content { padding: 2rem; }
}
</style>

<div class="deal-container">
    
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-up">
        <a href="{{ route('deals.showAll') }}" class="text-muted text-decoration-none fw-bold">
            <i class="bi bi-chevron-left me-2"></i>Back to Deals
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('deals.edit', $deal->id) }}" class="btn btn-modern btn-primary-modern">
                <i class="bi bi-pencil"></i> Edit Deal
            </a>
            <form action="{{ route('deals.destroy', $deal->id) }}" method="POST" onsubmit="return confirm('Archive this deal?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-modern btn-danger-outline">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="deal-hero animate-fade-up" style="animation-delay: 0.1s">
        <div class="hero-image-wrapper">
            @if($deal->image_url)
                <img src="{{ Storage::url($deal->image_url) }}" alt="{{ $deal->title }}">
            @else
                <div class="no-image-placeholder">
                    <i class="bi bi-stars"></i>
                </div>
            @endif
        </div>
        <div class="hero-content">
            <div class="discount-badge-large">
                <i class="bi bi-lightning-fill me-2"></i>
                @if($deal->discount_type === 'percentage')
                    {{ $deal->discount_value }}% Instant Discount
                @else
                    Flat ${{ number_format($deal->discount_value, 2) }} Off
                @endif
            </div>
            
            <h1 class="display-5 fw-800 mb-2">{{ $deal->title }}</h1>
            <p class="text-primary fw-bold fs-5 mb-4">
                <i class="bi bi-shop me-2"></i>{{ $deal->business->business_name ?? 'Premium Partner' }}
            </p>

            <div class="d-flex align-items-center gap-3">
                <div class="status-indicator {{ $deal->status === 'active' ? 'status-active' : 'status-expired' }}">
                    <span class="pulse-dot" style="width:8px; height:8px; background:currentColor; border-radius:50%"></span>
                    {{ strtoupper($deal->status) }}
                </div>
                <span class="text-muted small">
                    <i class="bi bi-clock me-1"></i> Added {{ $deal->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
    </div>

    <div class="bento-grid">
        <div class="glass-card animate-fade-up" style="grid-column: span 2; animation-delay: 0.2s">
            <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Description</h5>
            <p class="text-muted mb-0" style="line-height: 1.8">
                {{ $deal->description ?: 'No detailed description provided for this deal.' }}
            </p>
        </div>

        <div class="glass-card animate-fade-up" style="animation-delay: 0.3s">
            <h5 class="fw-bold mb-3"><i class="bi bi-ticket-perforated me-2 text-primary"></i>Redeem Code</h5>
            <div class="promo-tag">
                <span class="promo-code-text">{{ $deal->promo_code ?? 'NO CODE' }}</span>
                <button class="btn btn-sm btn-link text-primary p-0" onclick="navigator.clipboard.writeText('{{ $deal->promo_code }}')">
                    <i class="bi bi-copy"></i>
                </button>
            </div>
            <p class="text-muted small mt-3 mb-0 text-center">
                Min. Purchase: <strong>${{ number_format($deal->min_purchase, 2) }}</strong>
            </p>
        </div>

        <div class="glass-card animate-fade-up" style="animation-delay: 0.4s">
            <h5 class="fw-bold mb-4"><i class="bi bi-calendar-check me-2 text-primary"></i>Validity</h5>
            <div class="d-flex flex-column gap-3">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Starts</span>
                    <span class="fw-bold">{{ \Carbon\Carbon::parse($deal->start_date)->format('M d, Y') }}</span>
                </div>
                <div class="progress" style="height: 6px; background: rgba(255,255,255,0.05)">
                    <div class="progress-bar bg-primary" style="width: 70%"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Ends</span>
                    <span class="fw-bold text-danger">{{ \Carbon\Carbon::parse($deal->end_date)->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        <div class="glass-card animate-fade-up" style="grid-column: span 2; animation-delay: 0.5s">
            <h5 class="fw-bold mb-3"><i class="bi bi-shield-check me-2 text-primary"></i>Terms & Conditions</h5>
            <p class="text-muted small mb-0" style="font-style: italic">
                {{ $deal->terms ?: 'General terms and conditions apply. Contact business for more details.' }}
            </p>
        </div>
    </div>
</div>

<script>
    // Add a simple hover interaction for the progress bar or other elements
    document.querySelectorAll('.glass-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });
</script>

@endsection