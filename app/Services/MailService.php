<?php
namespace App\Services;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class MailService {
    public function send(string $to,string $toName,string $subject,string $body): bool {
        $mail=new PHPMailer(true);
        try {
            $mail->isSMTP();$mail->Host=config('mail.mailers.smtp.host','smtp.hostinger.com');
            $mail->SMTPAuth=true;$mail->Username=config('mail.mailers.smtp.username');
            $mail->Password=config('mail.mailers.smtp.password');$mail->SMTPSecure=PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port=(int)config('mail.mailers.smtp.port',465);$mail->CharSet='UTF-8';
            $mail->setFrom(config('mail.from.address'),config('mail.from.name'));
            $mail->addAddress($to,$toName);$mail->isHTML(true);$mail->Subject=$subject;$mail->Body=$body;
            $mail->send();return true;
        } catch(Exception $e){Log::error('Mail: '.$mail->ErrorInfo);return false;}
    }
    public function sendOrderConfirmation($order): bool {
        $body=View::make('emails.order-confirmation',['order'=>$order])->render();
        return $this->send($order->user->email,$order->user->name,"Pesanan #{$order->order_number} Berhasil - BelanjaYuk!",$body);
    }
    public function sendOrderStatusUpdate($order): bool {
        $body=View::make('emails.order-status',['order'=>$order])->render();
        return $this->send($order->user->email,$order->user->name,"Update Pesanan #{$order->order_number} - BelanjaYuk!",$body);
    }
    public function notifyAdminNewOrder($order): bool {
        $body=View::make('emails.admin-new-order',['order'=>$order])->render();
        return $this->send(config('app.admin_email'),'Admin',"Pesanan Baru #{$order->order_number}",$body);
    }
    public function notifyAdminPaymentProof($order): bool {
        $body=View::make('emails.admin-payment-proof',['order'=>$order])->render();
        return $this->send(config('app.admin_email'),'Admin',"Bukti Transfer #{$order->order_number}",$body);
    }
}
