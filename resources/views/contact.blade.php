@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
    --bg-dark:#09090b;
    --bg-darker:#050812;
    --bg-card:rgba(255,255,255,.03);
    --border-glass:rgba(255,255,255,.08);
    --text-main:#fff;
    --text-muted:#a1a1aa;

    --neon-purple:#a855f7;
    --neon-pink:#ec4899;
    --neon-cyan:#06b6d4;
    --neon-yellow:#eab308;
    --neon-green:#22c55e;
}

*{box-sizing:border-box}

body{
    background-color:var(--bg-dark);
    color:var(--text-main);
    font-family:'Plus Jakarta Sans',sans-serif;
    min-height:100vh;
    background-image:
        radial-gradient(at 10% 10%, rgba(168,85,247,.15) 0px, transparent 50%),
        radial-gradient(at 90% 90%, rgba(6,182,212,.15) 0px, transparent 50%),
        radial-gradient(at 50% 50%, rgba(236,72,153,.08) 0px, transparent 60%);
    background-attachment:fixed;
}

.hero-section{
    background:linear-gradient(135deg, rgba(168,85,247,.15) 0%, rgba(6,182,212,.1) 50%, rgba(236,72,153,.1) 100%);
    border-bottom:1px solid var(--border-glass);
    padding:70px 0 40px;
    text-align:center;
}

.hero-title{
    font-size:clamp(2rem, 5vw, 3.2rem);
    font-weight:900;
    letter-spacing:-1px;
    margin-bottom:.75rem;
    background:linear-gradient(90deg, var(--neon-cyan) 0%, var(--neon-pink) 50%, var(--neon-yellow) 100%);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
}

.hero-subtitle{
    font-size:1.05rem;
    color:var(--text-muted);
    margin:0;
}

.contact-shell{
    max-width:1200px;
    margin:-30px auto 60px;
    padding:0 12px;
}

.contact-card{
    background:rgba(20,20,30,.6);
    backdrop-filter:blur(20px);
    border:1px solid var(--border-glass);
    border-radius:22px;
    box-shadow:0 20px 60px rgba(0,0,0,.4);
    overflow:hidden;
}

.contact-grid{
    display:grid;
    grid-template-columns: 1fr;
}

@media (min-width: 992px){
    .contact-grid{ grid-template-columns: 0.9fr 1.1fr; }
}

.contact-left{
    padding:26px;
    background:linear-gradient(135deg, rgba(6,182,212,.08) 0%, rgba(168,85,247,.08) 55%, rgba(236,72,153,.06) 100%);
    border-bottom:1px solid var(--border-glass);
}

@media (min-width: 992px){
    .contact-left{
        border-bottom:none;
        border-right:1px solid var(--border-glass);
    }
}

.contact-right{
    padding:26px;
}

.kicker{
    color:var(--neon-cyan);
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:1.2px;
    font-size:.8rem;
    margin-bottom:10px;
}

.contact-heading{
    font-size:1.6rem;
    font-weight:900;
    margin:0 0 10px;
}

.contact-text{
    color:var(--text-muted);
    line-height:1.7;
    margin:0 0 18px;
}

.info-list{
    display:flex;
    flex-direction:column;
    gap:10px;
    margin:0;
    padding:0;
    list-style:none;
}

.info-item{
    display:flex;
    gap:10px;
    align-items:flex-start;
    padding:12px 12px;
    border:1px solid var(--border-glass);
    border-radius:14px;
    background:rgba(255,255,255,.03);
}

.info-ico{
    width:36px;
    height:36px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:rgba(6,182,212,.12);
    border:1px solid rgba(6,182,212,.25);
    color:var(--neon-cyan);
    flex:0 0 auto;
}

.info-title{
    font-weight:800;
    margin:0;
    font-size:.95rem;
}

.info-sub{
    margin:2px 0 0;
    color:var(--text-muted);
    font-size:.9rem;
    line-height:1.5;
    word-break:break-word;
}

.form-label{
    color:var(--text-muted);
    font-weight:700;
    font-size:.9rem;
    margin-bottom:6px;
}

.form-control, .form-select, textarea{
    background:rgba(0,0,0,.3) !important;
    border:1.5px solid var(--border-glass) !important;
    color:var(--text-main) !important;
    border-radius:14px !important;
    padding:12px 14px !important;
}

.form-control:focus, textarea:focus{
    outline:none !important;
    border-color:var(--neon-cyan) !important;
    box-shadow:0 0 0 .18rem rgba(6,182,212,.15) !important;
}

.btn-send{
    width:100%;
    border:none;
    border-radius:14px;
    padding:12px 14px;
    font-weight:900;
    letter-spacing:.3px;
    background:linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
    color:#050812;
    transition:transform .15s ease, filter .2s ease;
}

.btn-send:hover{ transform:translateY(-1px); filter:brightness(1.05); }

.alert{
    border-radius:14px;
    border:1px solid var(--border-glass);
    background:rgba(255,255,255,.03);
    color:var(--text-main);
}
.alert-success{ border-color:rgba(34,197,94,.35); }
.alert-danger{ border-color:rgba(236,72,153,.35); }

.invalid-feedback{ display:block; }
</style>

<section class="hero-section">
    <div class="container">
        <h1 class="hero-title">Contact Us</h1>
        <p class="hero-subtitle">Send a message and get help with setup, billing, or support.</p>
    </div>
</section>

<div class="contact-shell">
    <div class="contact-card">
        <div class="contact-grid">
            <div class="contact-left">
                <div class="kicker">Support</div>
                <h2 class="contact-heading">Let’s solve it fast</h2>
                <p class="contact-text">
                    Share your issue or question. Include screenshots/steps if possible for quicker resolution.
                </p>

                <ul class="info-list">
                    <li class="info-item">
                        <div class="info-ico"><i class="bi bi-envelope"></i></div>
                        <div>
                            <p class="info-title">Email</p>
                            <p class="info-sub">support@yourdomain.com</p>
                        </div>
                    </li>

                    <li class="info-item">
                        <div class="info-ico"><i class="bi bi-telephone"></i></div>
                        <div>
                            <p class="info-title">Phone</p>
                            <p class="info-sub">+91 00000 00000</p>
                        </div>
                    </li>

                    <li class="info-item">
                        <div class="info-ico"><i class="bi bi-clock"></i></div>
                        <div>
                            <p class="info-title">Hours</p>
                            <p class="info-sub">Mon–Sat, 10:00 AM – 7:00 PM</p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="contact-right">
                @if (session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-3">Please fix the errors and try again.</div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Your name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="you@example.com">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" value="{{ old('subject') }}"
                                   class="form-control @error('subject') is-invalid @enderror"
                                   placeholder="What is this about?">
                            @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Message</label>
                            <textarea name="message" rows="6"
                                      class="form-control @error('message') is-invalid @enderror"
                                      placeholder="Write your message...">{{ old('message') }}</textarea>
                            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn-send">
                                <i class="bi bi-send me-2"></i> Send message
                            </button>
                        </div>

                        <div class="col-12">
                            <p class="contact-text" style="margin: 6px 0 0;">
                                By sending this message, you agree to be contacted back about your request.
                            </p>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
