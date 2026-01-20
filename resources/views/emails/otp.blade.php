<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Verifikasi</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #2dd4bf; text-align: center;">Verifikasi Akun Bimbingan Konseling</h2>
        <p>Halo,</p>
        <p>Terima kasih telah melakukan registrasi. Berikut adalah kode OTP Anda untuk memverifikasi akun Anda:</p>
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; background: #f3f4f6; padding: 10px 20px; border-radius: 5px; color: #1f2937;">
                {{ $otp }}
            </span>
        </div>
        <p>Kode ini akan daluarsa dalam 10 menit. Jika Anda tidak merasa melakukan registrasi, silakan abaikan email ini.</p>
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #888; text-align: center;">&copy; {{ date('Y') }} Sistem Bimbingan Konseling. All rights reserved.</p>
    </div>
</body>
</html>
