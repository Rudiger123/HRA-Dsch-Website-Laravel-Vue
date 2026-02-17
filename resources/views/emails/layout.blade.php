<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - HRA Dschang</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #00A651, #007a3d);
            padding: 40px 40px 30px;
            text-align: center;
        }
        .header-logo {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .header p {
            color: rgba(255,255,255,0.8);
            font-size: 14px;
            margin-top: 4px;
        }
        .body { padding: 40px; }
        .greeting {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 16px;
        }
        .text {
            font-size: 15px;
            color: #4b5563;
            margin-bottom: 16px;
        }
        .info-card {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            margin: 24px 0;
        }
        .info-card h3 {
            font-size: 14px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label {
            color: #6b7280;
            font-weight: 500;
            min-width: 140px;
        }
        .info-value {
            color: #1f2937;
            font-weight: 600;
            text-align: right;
            flex: 1;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-confirmed { background: #d1fae5; color: #065f46; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .btn {
            display: inline-block;
            padding: 14px 28px;
            background: #00A651;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 15px;
            margin: 8px 4px;
        }
        .btn-secondary {
            background: transparent;
            border: 2px solid #00A651;
            color: #00A651 !important;
        }
        .btn-danger { background: #dc2626; }
        .actions { text-align: center; margin: 32px 0; }
        .divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 32px 0;
        }
        .alert {
            padding: 16px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
        }
        .alert-info { background: #eff6ff; border-left: 4px solid #3b82f6; color: #1e40af; }
        .alert-success { background: #f0fdf4; border-left: 4px solid #22c55e; color: #166534; }
        .alert-warning { background: #fffbeb; border-left: 4px solid #f59e0b; color: #92400e; }
        .footer {
            background: #f8fafc;
            padding: 32px 40px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            font-size: 13px;
            color: #9ca3af;
            margin-bottom: 8px;
        }
        .footer strong { color: #6b7280; }
        .footer a { color: #00A651; text-decoration: none; }
        .social-links { margin: 16px 0; }
        .social-links a { margin: 0 8px; }
        .list {
            list-style: none;
            padding: 0;
        }
        .list li {
            padding: 8px 0;
            font-size: 14px;
            color: #4b5563;
        }
        .list li:before {
            content: "✓ ";
            color: #00A651;
            font-weight: bold;
            margin-right: 8px;
        }
        @media (max-width: 600px) {
            .container { margin: 0; border-radius: 0; }
            .body { padding: 24px; }
            .header { padding: 24px; }
            .info-row { flex-direction: column; gap: 4px; }
            .info-value { text-align: left; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-logo">🏥</div>
            <h1>HRA Dschang</h1>
            <p>Hôpital Régional Annexe de Dschang</p>
        </div>

        <div class="body">
            @yield('content')
        </div>

        <div class="footer">
            <p><strong>HRA Dschang</strong> — Hôpital Régional Annexe de Dschang</p>
            <p>📍 Dschang, Région de l'Ouest, Cameroun<br>
               📞 +237 233 44 55 66 | 🌐 hradschang.cm</p>
            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 16px 0;">
            <p>Cet email a été envoyé automatiquement. Merci de ne pas y répondre directement.<br>
               Pour nous contacter : contact@hradschang.cm</p>
        </div>
    </div>
</body>
</html>
