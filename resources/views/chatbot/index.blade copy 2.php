@extends('layouts.kai')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<style>
    .markdown-content table { width: 100%; margin-bottom: 1rem; color: #212529; border-collapse: collapse; }
    .markdown-content th, .markdown-content td { padding: 0.75rem; vertical-align: top; border-top: 1px solid #dee2e6; }
    .markdown-content thead th { vertical-align: bottom; border-bottom: 2px solid #dee2e6; background-color: #f8f9fa; }
    .markdown-content p:last-child { margin-bottom: 0; }
    .markdown-content ul, .markdown-content ol { padding-left: 1.5rem; margin-bottom: 0; }
    .chat-bubble-ai { border-top-left-radius: 0 !important; }
    .chat-bubble-user { border-top-right-radius: 0 !important; }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0 d-flex flex-column" style="height: 75vh; min-height: 550px;">

                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-robot"></i> AI Asisten Gudang
                    </h5>
                    <button id="clear-btn" class="btn btn-sm btn-light text-primary fw-bold">
                        Reset Obrolan
                    </button>
                </div>

                <div id="chat-box" class="card-body overflow-auto d-flex flex-column gap-3 bg-light" style="flex: 1;">
                    <div class="p-3 rounded-3 shadow-sm align-self-start bg-white border chat-bubble-ai" style="max-width: 85%;">
                        Halo! Saya asisten pintar untuk SaaS Inventaris Anda. Ada yang bisa saya bantu terkait stok atau gudang hari ini?
                    </div>
                </div>

                <div class="card-footer bg-white border-top p-3">
                    <form id="chat-form">
                        <div class="input-group input-group-lg">
                            <input type="text" id="chat-input" class="form-control" placeholder="Tanyakan soal stok, barang, atau fitur gudang..." autocomplete="off" required>
                            <button type="submit" id="send-btn" class="btn btn-primary px-4 fw-bold">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const sendBtn = document.getElementById('send-btn');
    const clearBtn = document.getElementById('clear-btn');
    const csrfToken = '{{ csrf_token() }}';

    // Mengambil riwayat obrolan dari Controller (dijadikan JSON agar mudah dirender JS)
    const chatHistory = @json($history);

    // Fungsi untuk merender pesan ke layar
    function appendMessage(sender, message) {
        const div = document.createElement('div');
        div.classList.add('p-3', 'rounded-3', 'shadow-sm');
        div.style.maxWidth = '85%';

        if (sender === 'user') {
            div.classList.add('align-self-end', 'bg-primary', 'text-white', 'chat-bubble-user');
            // Menampilkan teks biasa untuk user
            div.innerHTML = message.replace(/\n/g, '<br>');
        } else {
            div.classList.add('align-self-start', 'bg-white', 'border', 'markdown-content', 'chat-bubble-ai');
            // Menggunakan Marked.js untuk memproses Markdown (Tabel, Bold, List) dari AI
            div.innerHTML = marked.parse(message);
        }

        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Render riwayat obrolan saat halaman pertama kali dimuat
    if (chatHistory && chatHistory.length > 0) {
        chatHistory.forEach(chat => {
            appendMessage(chat.role, chat.content);
        });
    }

    // Handle saat form dikirim
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const text = chatInput.value.trim();
        if (!text) return;

        // Tampilkan pesan user
        appendMessage('user', text);

        chatInput.value = '';
        chatInput.disabled = true;
        sendBtn.disabled = true;

        // Indikator Loading Bootstrap
        const loadingId = 'loading-' + Date.now();
        const loadingDiv = document.createElement('div');
        loadingDiv.id = loadingId;
        loadingDiv.classList.add('align-self-start', 'text-muted', 'small', 'fst-italic', 'px-3');
        loadingDiv.innerHTML = '<span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span> AI sedang berpikir...';
        chatBox.appendChild(loadingDiv);
        chatBox.scrollTop = chatBox.scrollHeight;

        try {
            const response = await fetch('{{ route("chatbot.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: text })
            });

            const data = await response.json();
            document.getElementById(loadingId).remove();

            if (response.ok) {
                appendMessage('ai', data.reply);
            } else {
                appendMessage('ai', '**Error:** ' + (data.error || 'Terjadi kesalahan sistem.'));
            }
        } catch (error) {
            document.getElementById(loadingId).remove();
            appendMessage('ai', '**Koneksi gagal.** Silakan periksa jaringan Anda.');
        } finally {
            chatInput.disabled = false;
            sendBtn.disabled = false;
            chatInput.focus();
        }
    });

    // Handle tombol reset obrolan
    clearBtn.addEventListener('click', async function() {
        if(!confirm('Anda yakin ingin menghapus riwayat percakapan ini?')) return;

        await fetch('{{ route("chatbot.clear") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });

        window.location.reload();
    });
</script>
@endsection