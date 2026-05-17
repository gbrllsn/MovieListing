<?php
session_start();
// If logged in, send to the catalog
if (isset($_SESSION['user_id'])) {
    header("Location: assets/movies.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vesper — Cinema Discovery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet"> 
    
    <link rel="stylesheet" href="public/assets/css/style.css">
    <style>
        :root {
            --accent: #6c63ff;
            --accent-dim: rgba(108, 99, 255, 0.18);
            --glass: rgba(255,255,255,0.04);
            --border: rgba(255,255,255,0.09);
            --text-muted: rgba(255,255,255,0.38);
            --text-sub: rgba(255,255,255,0.6);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Outfit', sans-serif;
            background: #08080a;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-bg {
            position: fixed;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            filter: brightness(0.18) saturate(0.6);
            z-index: 0;
        }

        .hero-vignette {
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse at center, transparent 30%, #08080a 85%);
            z-index: 1;
        }

        .content-wrap {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        /* ---------- Branding ---------- */
        .brand-label {
            font-family: 'Outfit', sans-serif;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.22em;
            color: var(--accent);
            text-transform: uppercase;
            display: block;
        }

        .brand-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(3.2rem, 7vw, 5.5rem);
            font-weight: 700;
            letter-spacing: 0.16em;
            color: #fff;
            line-height: 1;
            text-transform: uppercase;
        }

        .brand-rule {
            width: 32px;
            height: 1px;
            background: var(--accent);
            margin: 1.1rem auto 0;
            opacity: 0.7;
        }

        /* ---------- Panel ---------- */
        .auth-panel {
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 2px;
            backdrop-filter: blur(22px) saturate(1.4);
            -webkit-backdrop-filter: blur(22px) saturate(1.4);
            overflow: hidden;
        }

        /* ---------- Tabs ---------- */
        .auth-tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-bottom: 1px solid var(--border);
        }

        .auth-tab {
            padding: 1rem 0;
            background: transparent;
            border: none;
            font-family: 'Outfit', sans-serif;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--text-muted);
            cursor: pointer;
            transition: color 0.25s, background 0.25s;
            position: relative;
        }

        .auth-tab::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0; right: 0;
            height: 1px;
            background: var(--accent);
            transform: scaleX(0);
            transition: transform 0.25s ease;
        }

        .auth-tab.active {
            color: #fff;
        }

        .auth-tab.active::after {
            transform: scaleX(1);
        }

        /* ---------- Forms ---------- */
        .form-pane {
            padding: 2.5rem 2.5rem 2rem;
            display: none;
        }

        .form-pane.active { display: block; }

        .field-label {
            font-size: 9px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--text-muted);
            display: block;
            margin-bottom: 0.45rem;
        }

        .field-input {
            width: 100%;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 1px;
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 0.88rem;
            font-weight: 300;
            padding: 0.72rem 0.95rem;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }

        .field-input::placeholder { color: rgba(255,255,255,0.2); }

        .field-input:focus {
            border-color: rgba(108, 99, 255, 0.55);
            background: rgba(108,99,255,0.06);
        }

        .field-group { margin-bottom: 1.3rem; }

        /* ---------- Buttons ---------- */
        .btn-primary-vesper {
            width: 100%;
            padding: 0.85rem;
            background: var(--accent);
            border: none;
            border-radius: 1px;
            font-family: 'Outfit', sans-serif;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: #fff;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: background 0.22s, opacity 0.22s, transform 0.18s;
        }

        .btn-primary-vesper:hover {
            background: #7b74ff;
            transform: translateY(-1px);
        }

        .btn-primary-vesper:active { transform: translateY(0); }

        /* ---------- Guest ---------- */
        .guest-divider {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            margin: 1.5rem 0 1.2rem;
        }

        .guest-divider span {
            font-size: 9px;
            letter-spacing: 0.14em;
            color: var(--text-muted);
            text-transform: uppercase;
            white-space: nowrap;
        }

        .guest-divider::before,
        .guest-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .btn-guest {
            width: 100%;
            padding: 0.78rem;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 1px;
            font-family: 'Outfit', sans-serif;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--text-sub);
            cursor: pointer;
            transition: border-color 0.22s, color 0.22s, transform 0.18s;
        }

        .btn-guest:hover {
            border-color: rgba(255,255,255,0.28);
            color: #fff;
            transform: translateY(-1px);
        }

        /* ---------- Footer note ---------- */
        .panel-foot {
            padding: 1rem 2.5rem 1.6rem;
            font-size: 10px;
            letter-spacing: 0.12em;
            color: var(--text-muted);
            text-align: center;
            border-top: 1px solid var(--border);
        }

        .panel-foot a {
            color: rgba(108,99,255,0.85);
            text-decoration: none;
            transition: color 0.2s;
        }

        .panel-foot a:hover { color: #fff; }

        /* ---------- Fade-in ---------- */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .brand-wrap { animation: fadeUp 0.7s ease both; }

        .auth-panel { position: relative; z-index: 10; }

        .hero-bg,
        .hero-vignette {
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="hero-bg"></div>
    <div class="hero-vignette"></div>

    <div class="hero">
        <div class="content-wrap">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-7">
                        <div class="brand-wrap text-center mb-5">
                            <span class="brand-label">Premium Cinema Tracking</span>
                            <h1 class="brand-title mt-2">VESPER</h1>
                            <div class="brand-rule"></div>
                        </div>

                        <div class="auth-panel">
                            <div class="auth-tabs">
                                <button class="auth-tab active" onclick="switchTab('login', this)">Sign In</button>
                                <button class="auth-tab" onclick="switchTab('register', this)">Create Account</button>
                            </div>

                            <div class="form-pane active" id="pane-login">

                                <?php if (isset($_GET['error']) && $_GET['error'] == '1'): ?>
                                    <div style="color: #ff6464; font-size: 11px; letter-spacing: 0.1em; text-align: center; margin-bottom: 15px; border: 1px solid rgba(255,100,100,0.2); padding: 10px; background: rgba(255,100,100,0.05); text-transform: uppercase;">
                                        Access Denied: Invalid Credentials
                                    </div>
                                <?php endif; ?>

                                <form action="../../app/controllers/auth/login.php" method="POST">
                                    <input type="hidden" name="action" value="login">
                                    <div class="field-group">
                                        <label class="field-label">Username or Email</label>
                                        <input type="text" name="identifier" class="field-input" placeholder="username or name@example.com" required>
                                    </div>
                                    <div class="field-group">
                                        <label class="field-label">Password</label>
                                        <input type="password" name="password" class="field-input" placeholder="••••••••" required>
                                    </div>
                                    <button type="submit" class="btn-primary-vesper">Enter Vesper</button>
                                </form>

                                <div class="guest-divider"><span>or</span></div>
                                
                                <a href="guest.php" class="btn-guest text-decoration-none d-block text-center" style="padding: 12px; font-size: 10px; letter-spacing: 2px;">CONTINUE AS GUEST</a>
                            </div>

                            <div class="form-pane" id="pane-register">
                                <form action="../../app/controllers/auth/register.php" method="POST">
                                    <input type="hidden" name="action" value="register">
                                    <div class="field-group">
                                        <label class="field-label">Username</label>
                                        <input type="text" name="username" class="field-input" placeholder="choose a username" required>
                                    </div>
                                    <div class="field-group">
                                        <label class="field-label">Email Address</label>
                                        <input type="email" name="email" class="field-input" placeholder="name@example.com" required>
                                    </div>
                                    <div class="field-group">
                                        <label class="field-label">Password</label>
                                        <input type="password" name="password" class="field-input" placeholder="••••••••" required>
                                    </div>
                                    <div class="field-group" style="margin-bottom:0.4rem">
                                        <label class="field-label">Confirm Password</label>
                                        <input type="password" name="confirm_password" class="field-input" placeholder="••••••••" required>
                                    </div>
                                    <button type="submit" class="btn-primary-vesper">Create Account</button>
                                </form>
                            </div>

                            <div class="panel-foot">
                                By continuing you agree to Vesper's <a href="#">Terms</a> &amp; <a href="#">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
function switchTab(tab, btn) {
    document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.form-pane').forEach(p => p.classList.remove('active'));

    btn.classList.add('active');
    document.getElementById('pane-' + tab).classList.add('active');
}
</script>
</body>
</html>