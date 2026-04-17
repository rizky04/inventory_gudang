<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Messages\MessageRole;
use Laravel\Ai\Promptable;
use Illuminate\Support\Facades\Session;
use Stringable;

class AssistantGudang implements Agent, Conversational
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return <<<PROMPT
Anda adalah asisten AI untuk aplikasi manajemen inventaris gudang.

## Kemampuan Anda:
1. Menjawab pertanyaan tentang stok, produk, dan kategori berdasarkan data yang diberikan.
2. Menambahkan data ke database jika user meminta.

## Aturan Tambah Data:
Jika user ingin menambahkan data, Anda HARUS merespons dengan blok JSON berikut (tidak ada teks lain di luar blok):

Untuk tambah **kategori**:
```json
{"action":"add_category","data":{"name_category":"<nama kategori>"}}
```

Untuk tambah **produk**:
```json
{"action":"add_product","data":{"name_product":"<nama produk>","category_name":"<nama kategori>","description_product":"<deskripsi atau kosong>"}}
```

Untuk tambah **varian produk**:
```json
{"action":"add_variant","data":{"product_name":"<nama produk>","name_variant":"<nama varian>","price_variant":<harga angka>,"stok_variant":<stok angka>}}
```

Jika ada data yang kurang (misal kategori belum ada, atau produk belum ada), tanyakan dulu ke user.
Jika data lengkap, langsung balas dengan blok JSON di atas.

## Format Jawaban Biasa:
Untuk pertanyaan informasi (bukan tambah data), gunakan markdown yang rapi dan ringkas.
PROMPT;
    }

    public function messages(): iterable
    {
        $history = Session::get('chat_history', []);
        $history = array_slice($history, -6);

        $formattedMessages = [];

        foreach ($history as $chat) {
            if ($chat['role'] === 'user') {
                $formattedMessages[] = new Message(MessageRole::User, $chat['content']);
            } else {
                $formattedMessages[] = new Message(MessageRole::Assistant, $chat['content']);
            }
        }

        return $formattedMessages;
    }
}
