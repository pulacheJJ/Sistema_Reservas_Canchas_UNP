<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $token;
    protected $phoneNumberId;
    protected $baseUrl;

    public function __construct()
    {
        $this->token = env('WHATSAPP_TOKEN');
        $this->phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
        $this->baseUrl = 'https://graph.facebook.com/v17.0/' . $this->phoneNumberId . '/messages';
    }

    /**
     * Enviar un mensaje de texto por WhatsApp
     */
    public function enviarMensaje($telefono, $mensaje)
    {
        if (!$this->token || !$this->phoneNumberId) {
            Log::warning('WhatsApp Cloud API no está configurada.');
            return false;
        }

        // Formatear el teléfono (quitar '+' si lo tiene y asegurar formato internacional)
        $telefono = preg_replace('/[^0-9]/', '', $telefono);

        try {
            $response = Http::withToken($this->token)->post($this->baseUrl, [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $telefono,
                'type' => 'text',
                'text' => [
                    'preview_url' => false,
                    'body' => $mensaje
                ]
            ]);

            if ($response->successful()) {
                Log::info('Mensaje de WhatsApp enviado a: ' . $telefono);
                return true;
            }

            Log::error('Error al enviar WhatsApp: ' . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error('Excepción al enviar WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Enviar un documento (PDF) por WhatsApp
     * @param string $telefono Número de destino
     * @param string $documentUrl URL pública del PDF generado
     * @param string $filename Nombre del archivo
     * @param string $caption Mensaje que acompaña al archivo
     */
    public function enviarDocumento($telefono, $documentUrl, $filename = 'ticket.pdf', $caption = '')
    {
        if (!$this->token || !$this->phoneNumberId) {
            Log::warning('WhatsApp Cloud API no está configurada.');
            return false;
        }

        $telefono = preg_replace('/[^0-9]/', '', $telefono);

        try {
            $response = Http::withToken($this->token)->post($this->baseUrl, [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $telefono,
                'type' => 'document',
                'document' => [
                    'link' => $documentUrl,
                    'caption' => $caption,
                    'filename' => $filename
                ]
            ]);

            if ($response->successful()) {
                Log::info('Documento de WhatsApp enviado a: ' . $telefono);
                return true;
            }

            Log::error('Error al enviar Documento por WhatsApp: ' . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error('Excepción al enviar Documento por WhatsApp: ' . $e->getMessage());
            return false;
        }
    }
}
