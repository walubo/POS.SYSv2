<style>
    .custom-logo-container {
        position: relative;
        cursor: pointer;
        display: inline-block;
        padding-bottom: 4px; /* Space for the glow line */
    }

    .custom-corepos-logo {
        font-weight: 800;
        letter-spacing: 4px;
        text-transform: uppercase;
        position: relative;
        transition: 0.4s ease;
        animation: logo-float 3s ease-in-out infinite;
    }

    .custom-core {
        transition: 0.4s ease;
    }

    .custom-pos {
        color: #1da1ff;
        transition: 0.4s ease;
    }

    /* Glow line */
    .custom-logo-container::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0%;
        height: 3px;
        border-radius: 20px;
        background: linear-gradient(90deg, #1da1ff, #00e0ff);
        transition: 0.5s ease;
        box-shadow: 0 0 10px #1da1ff;
    }

    /* Hover Animation */
    .custom-logo-container:hover::after {
        width: 100%;
    }

    .custom-logo-container:hover .custom-corepos-logo {
        transform: translateY(-2px) scale(1.05);
        text-shadow:
            0 0 10px rgba(29, 161, 255, 0.8),
            0 0 20px rgba(29, 161, 255, 0.6),
            0 0 30px rgba(0, 224, 255, 0.5);
    }

    .custom-logo-container:hover .custom-pos {
        color: #00e0ff;
    }

    /* Floating effect */
    @keyframes logo-float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-3px); }
        100% { transform: translateY(0px); }
    }
</style>

<div {{ $attributes }}>
    <div class="custom-logo-container">
        <div class="custom-corepos-logo text-3xl">
            <span class="custom-core text-gray-900 dark:text-white">CORE</span><span class="custom-pos"> POS</span>
        </div>
    </div>
</div>
