@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* --- VIBRANT THEME --- */
:root {
    --bg-dark: #09090b;
    --bg-darker: #050812;
    --bg-card: rgba(255, 255, 255, 0.03);
    --border-glass: rgba(255, 255, 255, 0.08);
    --text-main: #ffffff;
    --text-muted: #a1a1aa;
    
    /* Neon Colors */
    --neon-purple: #a855f7;
    --neon-pink: #ec4899;
    --neon-cyan: #06b6d4;
    --neon-yellow: #eab308;
    --neon-green: #22c55e;
    --neon-orange: #f97316;
}

* { box-sizing: border-box; }

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
}

body::before,
body::after {
    content: "";
    position: fixed;
    inset: -40% -20%;
    z-index: -1;
    pointer-events: none;
    filter: blur(80px);
    opacity: 0.3;
}

body::before {
    background: radial-gradient(circle at 20% 50%, rgba(168, 85, 247, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(6, 182, 212, 0.15) 0%, transparent 50%);
    animation: float1 15s ease-in-out infinite;
}

body::after {
    background: radial-gradient(circle at 60% 30%, rgba(236, 72, 153, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 10% 70%, rgba(34, 197, 94, 0.1) 0%, transparent 50%);
    animation: float2 20s ease-in-out infinite;
}

@keyframes float1 {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(-30px, 30px) scale(1.05); }
}

@keyframes float2 {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(40px, -40px) scale(1.05); }
}

@keyframes slideInUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes promoGlow {
    0%, 100% { box-shadow: 0 0 15px rgba(234, 179, 8, 0.4); }
    50% { box-shadow: 0 0 30px rgba(234, 179, 8, 0.6); }
}

/* --- HERO SECTION --- */
.hero-section {
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.15) 0%, rgba(6, 182, 212, 0.1) 50%, rgba(236, 72, 153, 0.1) 100%);
    border-bottom: 1px solid var(--border-glass);
    padding: 70px 0 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
    animation: slideDown 0.8s ease;
}

.hero-title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 900;
    letter-spacing: -1px;
    margin-bottom: 1rem;
    background: linear-gradient(90deg, var(--neon-cyan) 0%, var(--neon-pink) 50%, var(--neon-yellow) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.1rem;
    color: var(--text-muted);
    margin: 0;
}

/* --- SEARCH & FILTER BAR --- */
.search-filter-bar {
    background: rgba(20, 20, 30, 0.6);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border-glass);
    border-radius: 20px;
    padding: 20px;
    margin: -30px auto 50px;
    max-width: 1200px;
    position: relative;
    z-index: 10;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    animation: slideInUp 0.8s ease;
}

.search-input-group {
    background: rgba(255, 255, 255, 0.05);
    border: 1.5px solid var(--border-glass);
    border-radius: 50px;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    margin-bottom: 15px;
}

.search-input-group:focus-within {
    border-color: var(--neon-cyan);
    background: rgba(6, 182, 212, 0.05);
    box-shadow: 0 0 20px rgba(6, 182, 212, 0.2);
}

.search-input {
    background: transparent;
    border: none;
    color: var(--text-main);
    width: 100%;
    outline: none;
    font-size: 1rem;
    font-family: inherit;
}

.search-input::placeholder {
    color: var(--text-muted);
}

.filter-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 12px;
}

.filter-select {
    background: rgba(0, 0, 0, 0.3);
    border: 1.5px solid var(--border-glass);
    color: var(--text-main);
    border-radius: 12px;
    padding: 10px 14px;
    font-size: 0.95rem;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-select:hover {
    border-color: var(--neon-purple);
    background: rgba(168, 85, 247, 0.05);
}

.filter-select:focus {
    outline: none;
    border-color: var(--neon-cyan);
    box-shadow: 0 0 15px rgba(6, 182, 212, 0.2);
}

.btn-reset {
    background: rgba(236, 72, 153, 0.1) !important;
    border-color: var(--neon-pink) !important;
    color: var(--neon-pink) !important;
    font-weight: 700;
}

.btn-reset:hover {
    background: rgba(236, 72, 153, 0.2) !important;
}

/* --- CARD GRID (4 COLUMNS) --- */
.deals-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
    padding: 20px 0 60px;
    animation: slideInUp 0.8s ease;
}

@media (min-width: 1400px) {
    .deals-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (min-width: 1024px) and (max-width: 1399px) {
    .deals-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (min-width: 768px) and (max-width: 1023px) {
    .deals-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 767px) {
    .deals-grid {
        grid-template-columns: 1fr;
    }
}

.deal-card {
    background: var(--bg-card);
    border: 1.5px solid var(--border-glass);
    border-radius: 24px;
    padding: 18px;
    position: relative;
    cursor: pointer;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    height: 100%;
}

.deal-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(236, 72, 153, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
}

.deal-card:hover {
    transform: translateY(-12px);
    border-color: var(--neon-pink);
    box-shadow: 0 20px 50px -10px rgba(236, 72, 153, 0.3);
    background: rgba(255, 255, 255, 0.05);
}

.deal-card:hover::before {
    opacity: 1;
}

/* Discount Tag */
.discount-tag {
    position: absolute;
    top: 0;
    right: 0;
    background: linear-gradient(135deg, var(--neon-yellow), var(--neon-orange));
    color: #000;
    font-weight: 900;
    font-size: 0.8rem;
    padding: 6px 12px;
    border-bottom-left-radius: 16px;
    box-shadow: 0 4px 15px rgba(234, 179, 8, 0.3);
}

/* Card Logo Box */
.card-logo-box {
    width: 90px;
    height: 90px;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(6, 182, 212, 0.15));
    border: 2px solid var(--border-glass);
    padding: 5px;
    margin-bottom: 14px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 2;
}

.deal-card:hover .card-logo-box {
    transform: scale(1.12);
    border-color: var(--neon-pink);
    box-shadow: 0 15px 35px rgba(236, 72, 153, 0.25);
}

.card-logo-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 16px;
}

.card-logo-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--neon-cyan);
    font-size: 2.5rem;
}

/* Card Text */
.card-biz {
    color: var(--neon-cyan);
    font-size: 0.75rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    margin-bottom: 6px;
}

.card-title {
    color: var(--text-main);
    font-size: 1.15rem;
    font-weight: 800;
    margin: 0;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* --- DEAL MODAL --- */
.deal-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(8px);
    z-index: 1000;
    display: none;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    padding: 20px;
    overflow-y: auto;
}

.deal-modal-backdrop.show {
    display: flex;
    opacity: 1;
}

.deal-modal {
    background: linear-gradient(135deg, #0f0f15 0%, #1a1a25 100%);
    border: 1px solid var(--border-glass);
    width: 100%;
    max-width: 1000px;
    border-radius: 30px;
    overflow: hidden;
    position: relative;
    transform: scale(0.9);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 0 60px rgba(168, 85, 247, 0.25);
    display: flex;
    flex-direction: column;
    margin: auto;
}

@media (min-width: 992px) {
    .deal-modal {
        flex-direction: row;
        max-height: 80vh;
    }
}

.deal-modal-backdrop.show .deal-modal {
    transform: scale(1);
}

/* Modal Image Side */
.modal-image-side {
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(6, 182, 212, 0.15));
    position: relative;
    min-height: 250px;
    flex: 0 0 auto;
}

@media (min-width: 992px) {
    .modal-image-side {
        width: 40%;
        max-height: 80vh;
    }
}

.modal-image-side img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.modal-overlay-gradient {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(9, 9, 11, 0.95), transparent);
    pointer-events: none;
}

/* Modal Content Side */
.modal-content-side {
    padding: 30px;
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    max-height: 80vh;
    margin-top: 20px;
}

@media (max-width: 991px) {
    .modal-content-side {
        max-height: auto;
        padding: 20px;
        margin-top: 15px;
    }
}

@media (max-width: 576px) {
    .modal-content-side {
        padding: 15px;
        margin-top: 10px;
    }
}

.close-modal-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid var(--border-glass);
    color: var(--text-main);
    width: 42px;
    height: 42px;
    border-radius: 50%;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.close-modal-btn:hover {
    background: var(--neon-pink);
    border-color: var(--neon-pink);
    transform: rotate(90deg);
}

.modal-discount {
    font-family: 'Outfit', sans-serif;
    font-size: clamp(2.5rem, 6vw, 3.5rem);
    font-weight: 900;
    color: var(--neon-yellow);
    line-height: 1;
    margin-bottom: 0.5rem;
    text-shadow: 0 4px 20px rgba(234, 179, 8, 0.3);
}

.modal-title {
    font-size: clamp(1.6rem, 4vw, 2.2rem);
    font-weight: 800;
    margin-bottom: 1rem;
    line-height: 1.1;
    color: var(--text-main);
}

.modal-business {
    color: var(--neon-cyan);
    font-weight: 700;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1rem;
}

.modal-meta {
    display: flex;
    gap: 16px;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
    color: var(--text-muted);
    flex-wrap: wrap;
}

.modal-meta span {
    display: flex;
    align-items: center;
    gap: 6px;
}

.modal-meta i {
    color: var(--neon-cyan);
}

.modal-section {
    margin-bottom: 1.8rem;
}

.modal-section-title {
    font-size: 0.9rem;
    font-weight: 800;
    color: var(--neon-cyan);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.8rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.modal-desc {
    line-height: 1.7;
    color: var(--text-muted);
    font-size: 0.95rem;
}

/* Business Description Style */
.modal-business-desc {
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.08) 0%, rgba(6, 182, 212, 0.05) 100%);
    border-left: 3px solid var(--neon-purple);
    padding: 12px 15px;
    border-radius: 8px;
    line-height: 1.6;
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-bottom: 1rem;
    font-style: italic;
}

.modal-deal-desc {
    line-height: 1.7;
    color: var(--text-muted);
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
}

/* --- LOCATIONS GRID (COMPACT) --- */
.locations-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 10px;
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .locations-grid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 8px;
    }
}

@media (max-width: 480px) {
    .locations-grid {
        grid-template-columns: 1fr;
    }
}

.location-card {
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(168, 85, 247, 0.05) 100%);
    border: 1.5px solid rgba(6, 182, 212, 0.3);
    border-radius: 14px;
    padding: 12px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.location-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, transparent 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.location-card:hover {
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(168, 85, 247, 0.1) 100%);
    border-color: var(--neon-cyan);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(6, 182, 212, 0.15);
}

.location-card:hover::before {
    opacity: 1;
}

.location-header {
    display: flex;
    align-items: flex-start;
    gap: 6px;
    margin-bottom: 8px;
}

.location-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(6, 182, 212, 0.1));
    border: 1px solid rgba(34, 197, 94, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--neon-green);
    flex-shrink: 0;
    font-size: 1rem;
}

.location-name {
    font-weight: 700;
    color: var(--text-main);
    font-size: 0.9rem;
    flex-grow: 1;
    line-height: 1.2;
}

.location-details {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.location-row {
    display: flex;
    align-items: flex-start;
    gap: 6px;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.location-row-icon {
    color: var(--neon-cyan);
    flex-shrink: 0;
    margin-top: 1px;
    font-size: 0.8rem;
}

.location-text {
    line-height: 1.3;
    font-size: 0.75rem;
}

.location-badge {
    display: inline-block;
    background: rgba(34, 197, 94, 0.15);
    border: 1px solid rgba(34, 197, 94, 0.3);
    color: var(--neon-green);
    padding: 3px 6px;
    border-radius: 4px;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-top: 6px;
}

/* --- TERMS & CONDITIONS --- */
.modal-terms {
    font-size: 0.85rem;
    color: var(--text-muted);
    line-height: 1.6;
    font-style: italic;
    padding: 12px;
    border-left: 3px solid var(--neon-purple);
    background: rgba(168, 85, 247, 0.05);
    border-radius: 6px;
}

/* --- ENHANCED PROMO BOX --- */
.modal-promo-box {
    background: linear-gradient(135deg, 
        rgba(168, 85, 247, 0.2) 0%,
        rgba(234, 179, 8, 0.1) 50%,
        rgba(236, 72, 153, 0.1) 100%);
    border: 2px solid var(--neon-yellow);
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    margin-top: auto;
    box-shadow: 0 0 30px rgba(234, 179, 8, 0.2);
    position: relative;
    overflow: hidden;
    animation: promoGlow 2s ease-in-out infinite;
}

.modal-promo-box::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
    animation: shimmer 2s infinite;
    pointer-events: none;
}

@keyframes shimmer {
    0%, 100% { transform: translateX(-100%); }
    50% { transform: translateX(100%); }
}

.modal-code-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--neon-yellow);
    font-weight: 800;
    position: relative;
    z-index: 1;
}

.modal-code {
    font-family: 'Outfit', sans-serif;
    font-size: 1.8rem;
    font-weight: 900;
    letter-spacing: 3px;
    color: var(--neon-yellow);
    display: block;
    margin-top: 8px;
    word-break: break-all;
    position: relative;
    z-index: 1;
    text-shadow: 0 0 10px rgba(234, 179, 8, 0.3);
}

/* Enhanced Minimum Purchase */
.modal-min-purchase {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin-top: 12px;
    font-weight: 600;
    position: relative;
    z-index: 1;
}

.modal-min-purchase strong {
    color: var(--neon-cyan);
    font-size: 0.9rem;
}

/* --- NO RESULTS --- */
.no-results {
    text-align: center;
    padding: 80px 20px;
}

.no-results i {
    font-size: 5rem;
    color: var(--neon-cyan);
    margin-bottom: 20px;
    opacity: 0.7;
}

.no-results-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 10px;
}

.no-results-text {
    color: var(--text-muted);
    font-size: 1.05rem;
}

/* --- PAGINATION --- */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 60px;
    margin-bottom: 40px;
}

.pagination {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    justify-content: center;
}

.page-link {
    padding: 10px 14px;
    border: 1px solid var(--border-glass);
    border-radius: 10px;
    color: var(--text-main);
    background: rgba(255, 255, 255, 0.05);
    transition: all 0.3s ease;
    text-decoration: none;
    cursor: pointer;
    font-weight: 600;
}

.page-link:hover {
    background: rgba(6, 182, 212, 0.1);
    border-color: var(--neon-cyan);
    color: var(--neon-cyan);
}

.page-link.active {
    background: linear-gradient(135deg, var(--neon-cyan), var(--neon-purple));
    border-color: transparent;
    color: var(--bg-dark);
    font-weight: 800;
}

/* Loader */
#loadingSpinner {
    text-align: center;
    padding: 4rem;
    display: none;
}

.spinner-border {
    color: var(--neon-cyan);
    width: 3rem;
    height: 3rem;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
/* FIX: Long URLs in descriptions */
.modal-business-desc,
.modal-deal-desc,
.modal-terms {
    word-break: break-all !important;
    overflow-wrap: break-word !important;
    hyphens: auto;
    line-height: 1.5 !important;
}

/* Ensure modal content doesn't overflow */
.modal-content-side {
    max-height: 70vh !important;
    overflow-y: auto;
}

/* Responsive text sizing for long content */
@media (max-width: 768px) {
    .modal-business-desc,
    .modal-deal-desc,
    .modal-terms {
        font-size: 0.85rem !important;
    }
}
/* FORCE PROMO BOX VISIBILITY */
/* FORCE PROMO BOX VISIBILITY (UPDATED) */
.modal-promo-box {
    /* keep your existing look, but prevent clipping */
    min-height: unset !important;
    width: 100% !important;

    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;

    /* stretch so wrapped lines use full width */
    align-items: stretch !important;
    gap: 8px !important;

    /* IMPORTANT: don't clip long promo/min-purchase text */
    overflow: visible !important;

    /* a little safer padding for multi-line content */
    padding: 18px 16px !important;
}

.modal-code-label,
.modal-code,
.modal-min-purchase {
    text-align: center !important;
}

.modal-code {
    min-height: unset !important;
    display: block !important;
    visibility: visible !important;

    /* better multi-line rendering */
    line-height: 1.2 !important;
    white-space: normal !important;

    /* wrap very long codes nicely */
    overflow-wrap: anywhere !important;
    word-break: break-word !important;

    /* reduce chance of clipping/overflow from wide letter spacing */
    letter-spacing: 2px !important;
    padding: 2px 6px !important;
}

.modal-min-purchase {
    min-height: unset !important;
    visibility: visible !important;
    line-height: 1.4 !important;
    white-space: normal !important;
    overflow-wrap: break-word !important;
    word-break: break-word !important;
    text-align: left !important;
}

</style>

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="container">
        <h1 class="hero-title">✨ Explore <span style="color: var(--neon-pink);">Exclusive</span> Deals</h1>
        <p class="hero-subtitle">Tap a card to reveal full details & visit nearby shops</p>
    </div>
</section>

<!-- SEARCH & FILTER BAR -->
<div class="container">
    <div class="search-filter-bar">
        <!-- Search Input -->
        <div class="search-input-group">
            <i class="bi bi-search" style="color: var(--text-muted);"></i>
            <input type="text" id="searchInput" class="search-input" placeholder="Search deals, businesses, promo codes...">
        </div>

        <!-- Filter Dropdowns -->
        <div class="filter-row">
            <select name="country" id="countrySelect" class="filter-select">
                <option value="">Country</option>
                @foreach($countries as $country)
                    <option value="{{ $country }}">{{ $country }}</option>
                @endforeach
            </select>

            <select name="state" id="stateSelect" class="filter-select" disabled>
                <option value="">State/Province</option>
            </select>

            <select name="city" id="citySelect" class="filter-select" disabled>
                <option value="">City</option>
            </select>

            <button id="resetFilters" type="button" class="filter-select btn-reset">
                <i class="bi bi-arrow-clockwise me-1"></i> Reset
            </button>
        </div>
    </div>
</div>

<!-- DEALS GRID -->
<div class="container pb-5">
    <div id="loadingSpinner">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="deals-grid" id="dealsGrid"></div>

    <div id="noResults" class="no-results" style="display: none;">
        <i class="bi bi-search"></i>
        <h4 class="no-results-title">No Deals Found</h4>
        <p class="no-results-text">Try adjusting your filters or search terms</p>
    </div>

    <div id="paginationContainer" class="pagination-container"></div>
</div>

<!-- DEAL MODAL - FULL INFO WITH LOCATIONS -->
<div class="deal-modal-backdrop mt-5" id="dealModal" onclick="closeModal(event)">
    <div class="deal-modal" onclick="event.stopPropagation()">
        <button class="close-modal-btn" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
        
        <div class="modal-image-side">
            <img id="m-image" src="" alt="Deal">
            <div class="modal-overlay-gradient"></div>
        </div>

        <div class="modal-content-side">
            <div class="modal-min-purchase" id="m-min-purchase"></div>
            <div class="modal-discount" id="m-discount"></div>
            <h2 class="modal-title" id="m-title"></h2>
            <div class="modal-business" id="m-business"></div>

            <div class="modal-meta">
                <span><i class="bi bi-calendar-event"></i> Start: <span id="m-start-date"></span></span>
                <span><i class="bi bi-calendar-x"></i> End: <span id="m-end-date"></span></span>
            </div>

            <!-- Business Description -->
            <div class="modal-section" id="m-biz-section" style="display: none;">
                <div class="modal-section-title">
                    <i class="bi bi-building"></i> About Business
                </div>
                <div class="modal-business-desc" id="m-biz-desc"></div>
            </div>

            <!-- Deal Description -->
            <div class="modal-section" id="m-desc-section" style="display: none;">
                <div class="modal-section-title">
                    <i class="bi bi-file-text"></i> Deal Details
                </div>
                <p class="modal-deal-desc" id="m-desc"></p>
            </div>

            <!-- Terms & Conditions -->
            <div class="modal-section" id="m-terms-section" style="display: none;">
                <div class="modal-section-title">
                    <i class="bi bi-shield-check"></i> Terms & Conditions
                </div>
                <div class="modal-terms" id="m-terms"></div>
            </div>

            <!-- Locations -->
            <div class="modal-section">
                <div class="modal-section-title">
                    <i class="bi bi-geo-alt"></i> Visit Our Locations
                </div>
                <div class="locations-grid" id="m-locations"></div>
            </div>

            <!-- Promo Code -->
            <div class="modal-promo-box">
                <div class="modal-code-label">Promo Code</div>
                <span class="modal-code" id="m-code"></span>
                <div class="modal-min-purchase" id="m-min-purchase"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    // Initial load
    fetchDeals("{{ route('explore.deals') }}");

    // Live search (debounced)
    let debounceTimer;
    $('#searchInput').on('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetchDeals("{{ route('explore.deals') }}");
        }, 300);
    });

    // Filter changes
    $('#countrySelect, #stateSelect, #citySelect').change(function() {
        fetchDeals("{{ route('explore.deals') }}");
    });

    // Reset filters
    $('#resetFilters').click(function() {
        $('#searchInput').val('');
        $('#countrySelect').val('').change();
        $('#stateSelect').val('').prop('disabled', true);
        $('#citySelect').val('').prop('disabled', true);
        fetchDeals("{{ route('explore.deals') }}");
    });

    // Country change - Load states
    $('#countrySelect').change(function() {
        const country = $(this).val();
        $('#stateSelect').html('<option value="">State/Province</option>').prop('disabled', !country);
        $('#citySelect').html('<option value="">City</option>').prop('disabled', true);

        if (country) {
            $.get("{{ route('get.states') }}", { country: country }, function(states) {
                states.forEach(state => {
                    $('#stateSelect').append(`<option value="${state}">${state}</option>`);
                });
            });
        }
    });

    // State change - Load cities
    $('#stateSelect').change(function() {
        const country = $('#countrySelect').val();
        const state = $(this).val();
        $('#citySelect').html('<option value="">City</option>').prop('disabled', !state);

        if (state && country) {
            $.get("{{ route('get.cities') }}", { country: country, state: state }, function(cities) {
                cities.forEach(city => {
                    $('#citySelect').append(`<option value="${city}">${city}</option>`);
                });
            });
        }
    });

    // Main fetch function
    function fetchDeals(url) {
        const params = {
            search: $('#searchInput').val(),
            country: $('#countrySelect').val(),
            state: $('#stateSelect').val(),
            city: $('#citySelect').val()
        };

        $('#loadingSpinner').show();
        $('#dealsGrid').css('opacity', 0.3);

        $.ajax({
            url: url,
            data: params,
            success: function(response) {
                let html = '';

                if (response.deals && response.deals.length > 0) {
                    response.deals.forEach((deal, index) => {
                        const logo = deal.logo_url 
                            ? `<img src="${deal.logo_url}" alt="${deal.business_name}">`
                            : `<div class="card-logo-placeholder"><i class="bi bi-building"></i></div>`;

                        const dealData = JSON.stringify(deal).replace(/"/g, '&quot;');

                        html += `
                            <div class="deal-card" onclick="openModal('${dealData}')">
                                <div class="discount-tag">${deal.discount_display}</div>
                                <div class="card-logo-box">
                                    ${logo}
                                </div>
                                <div class="card-biz">${deal.business_name}</div>
                                <h3 class="card-title">${deal.title}</h3>
                            </div>
                        `;
                    });
                    $('#noResults').hide();
                } else {
                    $('#noResults').show();
                }

                $('#dealsGrid').html(html).css('opacity', 1);
                $('#paginationContainer').html(response.pagination || '');
                $('#loadingSpinner').hide();
            },
            error: function() {
                $('#loadingSpinner').hide();
                console.error('Error loading deals');
            }
        });
    }

    // Pagination click
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        fetchDeals($(this).attr('href'));
        $('html, body').animate({ scrollTop: 0 }, 'slow');
    });
});

// Modal functions - FULL INFO WITH LOCATIONS + DESCRIPTIONS
// function openModal(dealJson) {
//     const deal = JSON.parse(dealJson.replace(/&quot;/g, '"'));

//     $('#m-title').text(deal.title);
//     $('#m-business').text(deal.business_name);
//     $('#m-discount').text(deal.discount_display);
//     $('#m-start-date').text(deal.start_date);
//     $('#m-end-date').text(deal.end_date);
//     $('#m-code').text(deal.promo_code || 'NO CODE NEEDED');

//     // Business Description
//     if (deal.business_description && deal.business_description.trim()) {
//         // $('#m-biz-desc').text(deal.business_description);
//         // $('#m-biz-section').show();
//         $('#m-biz-desc').html(deal.business_description.replace(/\n/g, '<br>'));
//         $('#m-biz-section').show();
//     } else {
//         $('#m-biz-section').hide();
//     }

//     // Deal Description
//     if (deal.description && deal.description.trim()) {
//         // $('#m-desc').text(deal.description);
//         // $('#m-desc-section').show();
//         $('#m-desc').html(deal.description.replace(/\n/g, '<br>'));
//         $('#m-desc-section').show();
//     } else {
//         $('#m-desc-section').hide();
//     }

//     // Terms & Conditions
//     if (deal.terms && deal.terms.trim()) {
//         $('#m-terms').text(deal.terms);
//         $('#m-terms-section').show();
//     } else {
//         $('#m-terms-section').hide();
//     }

//     // Min Purchase
//     if (deal.min_purchase && deal.min_purchase > 0) {
//         $('#m-min-purchase').html('💰 Minimum Purchase: <strong>₹' + deal.min_purchase.toLocaleString() + '</strong>');
//     } else {
//         $('#m-min-purchase').text('');
//     }

//     // Locations - Compact Grid Layout
//     const locationsHtml = deal.locations && deal.locations.length > 0
//         ? deal.locations.map((loc, idx) => `
//             <div class="location-card">
//                 <div class="location-header">
//                     <div class="location-icon">
//                         <i class="bi bi-shop"></i>
//                     </div>
//                     <div class="location-name">${loc.name || 'Branch'}</div>
//                 </div>
//                 <div class="location-details">
//                     <div class="location-row">
//                         <div class="location-row-icon"><i class="bi bi-geo-alt-fill"></i></div>
//                         <div class="location-text">
//                             <div>${loc.address || 'N/A'}</div>
//                             ${loc.city ? `<div>${loc.city}${loc.state ? ', ' + loc.state : ''}</div>` : ''}
//                         </div>
//                     </div>
//                     ${loc.country ? `
//                     <div class="location-row">
//                         <div class="location-row-icon"><i class="bi bi-flag"></i></div>
//                         <div class="location-text">${loc.country}</div>
//                     </div>
//                     ` : ''}
//                 </div>
//                 <span class="location-badge">✓ Active</span>
//             </div>
//         `).join('')
//         : '<p style="color: var(--text-muted); text-align: center; padding: 20px; font-size: 0.9rem;">No locations available</p>';
    
//     $('#m-locations').html(locationsHtml);

//     const imgUrl = deal.deal_image_url || 'https://via.placeholder.com/800x600/1a1a25/00d4ff?text=Deal+Offer';
//     $('#m-image').attr('src', imgUrl);

//     $('#dealModal').addClass('show');
//     document.body.style.overflow = 'hidden';
// }
function openModal(dealJson) {
    const deal = JSON.parse(dealJson.replace(/&quot;/g, '"'));

    // Set basic info FIRST
    $('#m-title').text(deal.title || 'No Title');
    $('#m-business').text(deal.business_name || 'Unknown Business');
    $('#m-discount').text(deal.discount_display || 'No Discount');
    $('#m-start-date').text(deal.start_date || 'N/A');
    $('#m-end-date').text(deal.end_date || 'N/A');

    // FIXED PROMO CODE - Force update with delay
    const promoCode = deal.promo_code || '';
    setTimeout(() => {
        $('#m-code').text(promoCode || 'NO CODE NEEDED');
        console.log('PROMO CODE SET:', promoCode || 'NO CODE NEEDED'); // Debug
    }, 50);

    // FIXED MIN PURCHASE - Force update with delay
    const minPurchase = parseFloat(deal.min_purchase || 0);
    setTimeout(() => {
        if (minPurchase > 0) {
            $('#m-min-purchase').html('Minimum Purchase: <strong>₹' + minPurchase.toLocaleString() + '</strong>');
        } else {
            $('#m-min-purchase').html('<span style="color: var(--neon-green);">No minimum purchase</span>');
        }
        console.log('MIN PURCHASE SET:', minPurchase); // Debug
    }, 100);

    // Business Description
    if (deal.business_description && deal.business_description.trim()) {
        $('#m-biz-desc').html(deal.business_description.replace(/\n/g, '<br>'));
        $('#m-biz-section').show();
    } else {
        $('#m-biz-section').hide();
    }

    // Deal Description
    if (deal.description && deal.description.trim()) {
        $('#m-desc').html(deal.description.replace(/\n/g, '<br>'));
        $('#m-desc-section').show();
    } else {
        $('#m-desc-section').hide();
    }

    // Terms & Conditions
    if (deal.terms && deal.terms.trim()) {
        $('#m-terms').html(deal.terms.replace(/\n/g, '<br>'));
        $('#m-terms-section').show();
    } else {
        $('#m-terms-section').hide();
    }

    // Locations
    const locationsHtml = deal.locations && deal.locations.length > 0
        ? deal.locations.map((loc, idx) => `
            <div class="location-card">
                <div class="location-header">
                    <div class="location-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div class="location-name">${loc.name || 'Branch'}</div>
                </div>
                <div class="location-details">
                    <div class="location-row">
                        <div class="location-row-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div class="location-text">
                            <div>${loc.address || 'N/A'}</div>
                            ${loc.city ? `<div>${loc.city}${loc.state ? ', ' + loc.state : ''}</div>` : ''}
                        </div>
                    </div>
                    ${loc.country ? `
                    <div class="location-row">
                        <div class="location-row-icon"><i class="bi bi-flag"></i></div>
                        <div class="location-text">${loc.country}</div>
                    </div>
                    ` : ''}
                </div>
                <span class="location-badge">✓ Active</span>
            </div>
        `).join('')
        : '<p style="color: var(--text-muted); text-align: center; padding: 20px; font-size: 0.9rem;">No locations available</p>';
    
    $('#m-locations').html(locationsHtml);

    // Image
    const imgUrl = deal.deal_image_url || 'https://via.placeholder.com/800x600/1a1a25/00d4ff?text=Deal+Offer';
    $('#m-image').attr('src', imgUrl);

    // Show modal LAST
    setTimeout(() => {
        $('#dealModal').addClass('show');
        document.body.style.overflow = 'hidden';
    }, 150);
}

function closeModal(event) {
    if (event && event.target !== document.getElementById('dealModal')) {
        return;
    }
    $('#dealModal').removeClass('show');
    document.body.style.overflow = 'auto';
}

// Close on Escape key
$(document).keydown(function(e) {
    if (e.key === 'Escape') closeModal();
});
</script>
@endsection
