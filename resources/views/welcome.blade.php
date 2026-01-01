@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --bg-dark: #09090b;
    --bg-darker: #050812;
    --bg-card: rgba(255, 255, 255, 0.03);
    --border-glass: rgba(255, 255, 255, 0.08);
    --text-main: #ffffff;
    --text-muted: #a1a1aa;
    
    --neon-purple: #a855f7;
    --neon-pink: #ec4899;
    --neon-cyan: #06b6d4;
    --neon-yellow: #eab308;
    --neon-green: #22c55e;
    --neon-orange: #f97316;
}

* { box-sizing: border-box; }

html, body {
    margin: 0;
    padding: 0;
    scroll-behavior: smooth;
}

body {
    background-color: var(--bg-dark);
    color: var(--text-main);
    font-family: 'Plus Jakarta Sans', sans-serif;
    min-height: 100vh;
    background-image: 
        radial-gradient(at 10% 10%, rgba(168, 85, 247, 0.15) 0px, transparent 50%),
        radial-gradient(at 90% 90%, rgba(6, 182, 212, 0.15) 0px, transparent 50%),
        radial-gradient(at 50% 50%, rgba(236, 72, 153, 0.08) 0px, transparent 60%);
    background-attachment: fixed;
    overflow-x: hidden;
}

/* --- ANIMATIONS --- */
@keyframes float1 {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(2deg); }
}

@keyframes float2 {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(20px) rotate(-2deg); }
}

@keyframes slideInUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInDown {
    from { opacity: 0; transform: translateY(-40px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-40px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes slideInRight {
    from { opacity: 0; transform: translateX(40px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes glow {
    0%, 100% { box-shadow: 0 0 20px rgba(168, 85, 247, 0.4), 0 0 40px rgba(6, 182, 212, 0.2); }
    50% { box-shadow: 0 0 30px rgba(168, 85, 247, 0.6), 0 0 60px rgba(6, 182, 212, 0.3); }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

@keyframes shimmer {
    0%, 100% { transform: translateX(-100%); }
    50% { transform: translateX(100%); }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* --- HERO SECTION --- */
.hero-main {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 120px 20px 80px;
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.15) 0%, rgba(6, 182, 212, 0.1) 50%, rgba(236, 72, 153, 0.1) 100%);
    border-bottom: 1px solid var(--border-glass);
    overflow: hidden;
}

.hero-main::before,
.hero-main::after {
    content: "";
    position: absolute;
    inset: -40% -20%;
    z-index: -1;
    pointer-events: none;
    filter: blur(100px);
    opacity: 0.2;
}

.hero-main::before {
    background: radial-gradient(circle at 20% 50%, rgba(168, 85, 247, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(6, 182, 212, 0.2) 0%, transparent 50%);
    animation: float1 20s ease-in-out infinite;
}

.hero-main::after {
    background: radial-gradient(circle at 60% 30%, rgba(236, 72, 153, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 10% 70%, rgba(34, 197, 94, 0.15) 0%, transparent 50%);
    animation: float2 25s ease-in-out infinite;
}

.hero-content {
    max-width: 1200px;
    width: 100%;
    display: grid;
    grid-template-columns: 1fr;
    gap: 40px;
    align-items: center;
    position: relative;
    z-index: 1;
}

@media (min-width: 992px) {
    .hero-content {
        grid-template-columns: 1fr 1fr;
        gap: 60px;
    }
}

.hero-text {
    animation: slideInLeft 0.8s ease forwards;
}

.hero-title {
    font-size: clamp(2.2rem, 8vw, 4rem);
    font-weight: 900;
    letter-spacing: -2px;
    line-height: 1.15;
    margin: 0 0 1rem;
    background: linear-gradient(90deg, var(--neon-cyan) 0%, var(--neon-pink) 50%, var(--neon-yellow) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 4px 20px rgba(168, 85, 247, 0.2);
}

.hero-subtitle {
    font-size: 1.15rem;
    color: var(--text-muted);
    line-height: 1.8;
    margin: 0 0 2rem;
    max-width: 95%;
}

.hero-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    animation: slideInUp 0.9s ease forwards;
}

.btn-primary-hero {
    padding: 14px 32px;
    border: none;
    border-radius: 16px;
    font-size: 1rem;
    font-weight: 800;
    letter-spacing: 0.3px;
    background: linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
    color: var(--bg-dark);
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary-hero:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(6, 182, 212, 0.4);
}

.btn-secondary-hero {
    padding: 14px 32px;
    border: 1.5px solid var(--border-glass);
    border-radius: 16px;
    font-size: 1rem;
    font-weight: 800;
    letter-spacing: 0.3px;
    background: rgba(255, 255, 255, 0.05);
    color: var(--text-main);
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    backdrop-filter: blur(10px);
}

.btn-secondary-hero:hover {
    border-color: var(--neon-pink);
    background: rgba(236, 72, 153, 0.1);
    color: var(--neon-pink);
}

.hero-image {
    position: relative;
    animation: float1 6s ease-in-out infinite;
    animation-delay: 0.2s;
}

.hero-image-box {
    width: 100%;
    aspect-ratio: 1;
    border-radius: 24px;
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(6, 182, 212, 0.15));
    border: 2px solid var(--border-glass);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
    animation: glow 3s ease-in-out infinite;
}

.hero-image-box::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    animation: shimmer 3s infinite;
    pointer-events: none;
}

.hero-image-content {
    font-size: 6rem;
    color: var(--neon-cyan);
    z-index: 1;
    animation: pulse 2s ease-in-out infinite;
}

/* --- TRUST STATS --- */
.trust-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
    margin-top: 3rem;
    animation: slideInUp 1s ease forwards;
}

.stat-card {
    background: var(--bg-card);
    border: 1px solid var(--border-glass);
    border-radius: 14px;
    padding: 16px;
    text-align: center;
    transition: all 0.3s ease;
}

.stat-card:hover {
    border-color: var(--neon-cyan);
    background: rgba(6, 182, 212, 0.08);
    transform: translateY(-4px);
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 900;
    color: var(--neon-cyan);
    margin: 0;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin: 4px 0 0;
}

/* --- FEATURES SECTION --- */
.section {
    padding: 80px 20px;
    position: relative;
}

.section-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 900;
    text-align: center;
    margin: 0 0 1rem;
    background: linear-gradient(90deg, var(--neon-cyan) 0%, var(--neon-pink) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: slideInDown 0.8s ease;
}

.section-subtitle {
    text-align: center;
    color: var(--text-muted);
    font-size: 1.1rem;
    max-width: 700px;
    margin: 0 auto 3rem;
    line-height: 1.7;
    animation: fadeIn 0.8s ease 0.2s forwards;
    opacity: 0;
}

.features-grid {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
}

.feature-card {
    background: var(--bg-card);
    border: 1.5px solid var(--border-glass);
    border-radius: 20px;
    padding: 32px 24px;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    animation: slideInUp 0.8s ease forwards;
    opacity: 0;
}

.feature-card:nth-child(1) { animation-delay: 0.1s; }
.feature-card:nth-child(2) { animation-delay: 0.2s; }
.feature-card:nth-child(3) { animation-delay: 0.3s; }
.feature-card:nth-child(4) { animation-delay: 0.4s; }
.feature-card:nth-child(5) { animation-delay: 0.5s; }
.feature-card:nth-child(6) { animation-delay: 0.6s; }

.feature-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(236, 72, 153, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
}

.feature-card:hover {
    transform: translateY(-12px);
    border-color: var(--neon-pink);
    box-shadow: 0 20px 50px -10px rgba(236, 72, 153, 0.3);
    background: rgba(255, 255, 255, 0.05);
}

.feature-card:hover::before {
    opacity: 1;
}

.feature-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(6, 182, 212, 0.15));
    border: 1px solid var(--border-glass);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--neon-cyan);
    font-size: 1.6rem;
    margin-bottom: 16px;
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
}

.feature-card:hover .feature-icon {
    transform: scale(1.15) rotate(-10deg);
    border-color: var(--neon-pink);
    box-shadow: 0 10px 25px rgba(236, 72, 153, 0.25);
}

.feature-title {
    font-size: 1.2rem;
    font-weight: 900;
    margin: 0 0 12px;
    color: var(--text-main);
    position: relative;
    z-index: 2;
}

.feature-desc {
    color: var(--text-muted);
    line-height: 1.7;
    font-size: 0.95rem;
    margin: 0;
    position: relative;
    z-index: 2;
}

/* --- BENEFITS SECTION --- */
.benefits-section {
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.08) 0%, rgba(6, 182, 212, 0.08) 100%);
    border: 1px solid var(--border-glass);
    border-radius: 24px;
    padding: 60px 40px;
    max-width: 1200px;
    margin: 0 auto 80px;
    animation: slideInUp 0.8s ease;
}

@media (max-width: 768px) {
    .benefits-section {
        padding: 40px 24px;
    }
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 32px;
}

.benefit-item {
    display: flex;
    gap: 16px;
    align-items: flex-start;
}

.benefit-check {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--neon-green), var(--neon-cyan));
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bg-dark);
    font-weight: 900;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.benefit-text h4 {
    font-size: 1.1rem;
    font-weight: 800;
    margin: 0 0 4px;
    color: var(--text-main);
}

.benefit-text p {
    color: var(--text-muted);
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0;
}

/* --- TESTIMONIALS SECTION --- */
.testimonials-section {
    padding: 80px 20px;
    position: relative;
}

.testimonials-grid {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
}

.testimonial-card {
    background: var(--bg-card);
    border: 1.5px solid var(--border-glass);
    border-radius: 20px;
    padding: 28px;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    animation: slideInUp 0.8s ease forwards;
    opacity: 0;
}

.testimonial-card:nth-child(1) { animation-delay: 0.1s; }
.testimonial-card:nth-child(2) { animation-delay: 0.2s; }
.testimonial-card:nth-child(3) { animation-delay: 0.3s; }

.testimonial-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--neon-cyan), var(--neon-purple), var(--neon-pink));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.testimonial-card:hover::before {
    transform: scaleX(1);
}

.testimonial-card:hover {
    transform: translateY(-8px);
    border-color: var(--neon-cyan);
    box-shadow: 0 15px 40px rgba(6, 182, 212, 0.25);
}

.rating {
    display: flex;
    gap: 4px;
    margin-bottom: 16px;
}

.star {
    color: var(--neon-yellow);
    font-size: 1rem;
}

.testimonial-text {
    color: var(--text-muted);
    line-height: 1.8;
    margin: 0 0 20px;
    font-style: italic;
    font-size: 0.95rem;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 12px;
}

.author-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--neon-purple), var(--neon-pink));
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bg-dark);
    font-weight: 900;
    font-size: 1.2rem;
}

.author-info h4 {
    font-size: 1rem;
    font-weight: 800;
    margin: 0;
    color: var(--text-main);
}

.author-info p {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin: 2px 0 0;
}

/* --- CTA SECTION --- */
.cta-section {
    max-width: 900px;
    margin: 0 auto;
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.15) 0%, rgba(6, 182, 212, 0.15) 50%, rgba(236, 72, 153, 0.1) 100%);
    border: 2px solid var(--border-glass);
    border-radius: 24px;
    padding: 60px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
    animation: slideInUp 0.8s ease;
}

@media (max-width: 768px) {
    .cta-section {
        padding: 40px 20px;
    }
}

.cta-section::before {
    content: "";
    position: absolute;
    inset: -50%;
    background: radial-gradient(circle, rgba(168, 85, 247, 0.2) 0%, transparent 70%);
    animation: float1 10s ease-in-out infinite;
    pointer-events: none;
    z-index: 0;
}

.cta-title {
    font-size: clamp(1.8rem, 5vw, 2.8rem);
    font-weight: 900;
    margin: 0 0 1rem;
    color: var(--text-main);
    position: relative;
    z-index: 1;
}

.cta-subtitle {
    font-size: 1.1rem;
    color: var(--text-muted);
    margin: 0 0 2rem;
    line-height: 1.7;
    position: relative;
    z-index: 1;
}

.cta-buttons {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}

/* --- RESPONSIVE --- */
@media (max-width: 768px) {
    .hero-actions {
        flex-direction: column;
    }

    .btn-primary-hero, .btn-secondary-hero {
        width: 100%;
        justify-content: center;
    }

    .section {
        padding: 60px 20px;
    }

    .benefits-section {
        margin-bottom: 60px;
    }

    .testimonials-section {
        padding: 60px 20px;
    }
}

/* --- UTILS --- */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
</style>

<!-- HERO SECTION -->
<section class="hero-main">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    Grow Your Business<br>
                    <span style="color: var(--neon-pink);">Get Premium Deals</span>
                </h1>
                <p class="hero-subtitle">
                    Join thousands of successful shop owners who use DealSpot to attract more customers, increase sales, and manage their business with ease. Create exclusive offers in minutes.
                </p>
                <div class="hero-actions">
                    <a href="#" class="btn-primary-hero">
                        <i class="bi bi-rocket-takeoff"></i> Start Free Today
                    </a>
                    <a href="{{ route('contact.show') }}" class="btn-secondary-hero">
                        <i class="bi bi-chat-left-text"></i> Learn More
                    </a>
                </div>
                <div class="trust-stats">
                    <div class="stat-card">
                        <p class="stat-number">10K+</p>
                        <p class="stat-label">Businesses</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-number">500K+</p>
                        <p class="stat-label">Customers</p>
                    </div>
                    <div class="stat-card">
                        <p class="stat-number">99.9%</p>
                        <p class="stat-label">Uptime</p>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <div class="hero-image-box">
                    <div class="hero-image-content">
                        <i class="bi bi-shop"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="section" style="background: linear-gradient(180deg, transparent 0%, rgba(168, 85, 247, 0.05) 100%);">
    <div class="container">
        <h2 class="section-title">✨ Powerful Features</h2>
        <p class="section-subtitle">
            Everything you need to create, manage, and promote your business deals—all in one platform
        </p>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-tags"></i>
                </div>
                <h3 class="feature-title">Create Deals</h3>
                <p class="feature-desc">Set up unlimited deals with discounts, promo codes, and location-based targeting in seconds.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
                <h3 class="feature-title">Track Analytics</h3>
                <p class="feature-desc">Monitor real-time engagement, customer interest, and conversion metrics for better insights.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3 class="feature-title">Manage Customers</h3>
                <p class="feature-desc">Build customer relationships with smart targeting and personalized deal recommendations.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-map"></i>
                </div>
                <h3 class="feature-title">Multiple Locations</h3>
                <p class="feature-desc">Manage deals across all your branches with location-specific control and inventory sync.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3 class="feature-title">Secure & Reliable</h3>
                <p class="feature-desc">Bank-grade security, automatic backups, and 99.9% uptime guarantee for peace of mind.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-headset"></i>
                </div>
                <h3 class="feature-title">24/7 Support</h3>
                <p class="feature-desc">Fast, friendly support team ready to help you succeed at any stage of your business journey.</p>
            </div>
        </div>
    </div>
</section>

<!-- BENEFITS SECTION -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Why Choose DealSpot?</h2>
        <div class="benefits-section">
            <div class="benefits-grid">
                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    <div class="benefit-text">
                        <h4>No Technical Skills Needed</h4>
                        <p>Intuitive interface built for non-tech users. Start creating deals in minutes.</p>
                    </div>
                </div>

                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    <div class="benefit-text">
                        <h4>Affordable Pricing</h4>
                        <p>Flexible plans that scale with your business. No hidden fees, cancel anytime.</p>
                    </div>
                </div>

                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    <div class="benefit-text">
                        <h4>Instant Customer Reach</h4>
                        <p>Automatically promoted to thousands of customers looking for your deals.</p>
                    </div>
                </div>

                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    <div class="benefit-text">
                        <h4>Real-Time Notifications</h4>
                        <p>Instant alerts when customers engage with your deals. Never miss an opportunity.</p>
                    </div>
                </div>

                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    <div class="benefit-text">
                        <h4>Mobile-First Design</h4>
                        <p>All your customers discover deals on mobile. We're optimized for their experience.</p>
                    </div>
                </div>

                <div class="benefit-item">
                    <div class="benefit-check">✓</div>
                    <div class="benefit-text">
                        <h4>Proven Results</h4>
                        <p>Businesses using DealSpot see 3x more foot traffic and higher sales conversion.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS SECTION -->
<section class="testimonials-section" style="background: linear-gradient(180deg, rgba(168, 85, 247, 0.05) 0%, transparent 100%);">
    <div class="container">
        <h2 class="section-title">💬 What Our Customers Say</h2>
        <p class="section-subtitle">
            Real feedback from real business owners who transformed their sales with DealSpot
        </p>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                </div>
                <p class="testimonial-text">
                    "DealSpot completely transformed how I attract customers to my store. In just 2 months, my foot traffic increased by 45% and I've been able to manage multiple deals effortlessly."
                </p>
                <div class="testimonial-author">
                    <div class="author-avatar">R</div>
                    <div class="author-info">
                        <h4>Rajesh Patel</h4>
                        <p>Fashion Retail Store Owner</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                </div>
                <p class="testimonial-text">
                    "What impressed me most was how easy it is to use. No coding knowledge required. The analytics dashboard shows exactly which deals work best. Best investment for my restaurant!"
                </p>
                <div class="testimonial-author">
                    <div class="author-avatar">S</div>
                    <div class="author-info">
                        <h4>Sneha Gupta</h4>
                        <p>Restaurant Chain Manager</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                </div>
                <p class="testimonial-text">
                    "The support team is incredible. They helped me set up everything perfectly, and now managing deals across 5 locations is a breeze. Can't imagine running my business without it."
                </p>
                <div class="testimonial-author">
                    <div class="author-avatar">A</div>
                    <div class="author-info">
                        <h4>Arjun Singh</h4>
                        <p>Multi-Store Business Owner</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="section">
    <div class="container">
        <div class="cta-section">
            <h2 class="cta-title">Ready to Boost Your Sales?</h2>
            <p class="cta-subtitle">
                Join successful business owners today. Create your first deal in under 5 minutes and start attracting more customers.
            </p>
            <div class="cta-buttons">
                <a href="#" class="btn-primary-hero">
                    <i class="bi bi-check-circle"></i> Get Started Free
                </a>
                <a href="{{ route('contact.show') }}" class="btn-secondary-hero">
                    <i class="bi bi-telephone"></i> Talk to Sales
                </a>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.animation = entry.target.dataset.animation;
            }
        });
    }, observerOptions);

    document.querySelectorAll('[data-animation]').forEach(el => {
        observer.observe(el);
    });

    // Smooth scroll for buttons
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        const target = $(this.getAttribute('href'));
        if(target.length) {
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
});
</script>

@endsection
