<?php
// filepath: app/Views/auth/waiting_approval.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Approval - Tracking App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .waiting-container {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 500px;
        }
        .icon-container {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
        }
        .icon-container i {
            font-size: 3rem;
            color: white;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        h1 {
            color: #333;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        p {
            color: #666;
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .info-box {
            background: #f3f4f6;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        .info-box ul {
            text-align: left;
            margin: 0;
            padding-left: 1.5rem;
        }
        .info-box li {
            color: #555;
            margin-bottom: 0.5rem;
        }
        .btn-back {
            padding: 0.75rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.3s;
        }
        .btn-back:hover {
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>
    <div class="waiting-container">
        <div class="icon-container">
            <i class="fas fa-clock"></i>
        </div>
        
        <h1>Pendaftaran Berhasil!</h1>
        <p>Akun Anda sedang menunggu approval dari admin. Anda akan menerima notifikasi via email setelah akun disetujui.</p>
        
        <div class="info-box">
            <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i> Langkah Selanjutnya:</h5>
            <ul>
                <li>Admin akan review pendaftaran Anda</li>
                <li>Proses approval biasanya 1-2 hari kerja</li>
                <li>Cek email untuk notifikasi approval</li>
                <li>Setelah approved, Anda bisa login</li>
            </ul>
        </div>
        
        <a href="<?= base_url('/') ?>" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>