@extends('layouts.kai')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<style>
    /* Menyesuaikan warna header card chatbot agar senada dengan UI Anda jika diperlukan, atau pakai bg-primary bawaan */
    .chat-header-custom { background-color: #0d6efd; color: white; } /* Anda bisa ganti hex ini jika warna biru aplikasi Anda berbeda */

    .markdown-content table { width: 100%; margin-bottom: 1rem; color: #212529; border-collapse: collapse; }
    .markdown-content th, .markdown-content td { padding: 0.75rem; vertical-align: top; border-top: 1px solid #dee2e6; }
    .markdown-content thead th { vertical-align: bottom; border-bottom: 2px solid #dee2e6; background-color: #f8f9fa; }
    .markdown-content p:last-child { margin-bottom: 0; }
    .markdown-content ul, .markdown-content ol { padding-left: 1.5rem; margin-bottom: 0; }

    /* Membuat bubble chat lebih rapi */
    .chat-bubble-ai { border-top-left-radius: 0 !important; }
    .chat-bubble-user { border-top-right-radius: 0 !important; }

    /* Scrollbar minimalis untuk area chat */
    #chat-box::-webkit-scrollbar { width: 8px; }
    #chat-box::-webkit-scrollbar-track { background: #f1f1f1; }
    #chat-box::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
    #chat-box::-webkit-scrollbar-thumb:hover { background: #adb5bd; }
</style>

<div class="container-fluid py-4"> <div class="row">
        <div class="col-12"> <div class="card shadow-sm border-0 d-flex flex-column" style="height: 80vh; min-height: 600px;">

                <div class="card-header chat-header-custom d-flex justify-content-between align-items-center py-3 border-0">
                    <h5 class="mb-0 d-flex align-items-center gap-2 fw-bold text-white">
                        <i class="fas fa-robot"></i> AI Asisten Gudang
                    </h5>
                    <button id="clear-btn" class="btn btn-sm btn-light text-primary fw-bold px-3">
                        Reset Obrolan
                    </button>
                </div>

                <div id="chat-box" class="card-body overflow-auto d-flex flex-column gap-4 bg-light" style="flex: 1; padding: 2rem;">

                    <div class="p-3 rounded-3 shadow-sm align-self-start bg-white border chat-bubble-ai" style="max-width: 80%;">
                        Halo! Saya asisten pintar untuk SaaS Inventaris Anda. Ada yang bisa saya bantu terkait stok atau gudang hari ini?
                    </div>

                </div>

                <div class="card-footer bg-white border-top p-3" style="border-bottom-left-radius: 0.375rem; border-bottom-right-radius: 0.375rem;">
                    <form id="chat-form">
                        <div class="input-group input-group-lg shadow-sm rounded">
                            <input type="text" id="chat-input" class="form-control border-end-0 shadow-none" placeholder="Tanyakan soal stok, barang, atau fitur gudang..." autocomplete="off" required style="border-radius: 0.375rem 0 0 0.375rem;">
                            <button type="submit" id="send-btn" class="btn btn-primary px-5 fw-bold" style="border-radius: 0 0.375rem 0.375rem 0;">
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

    const chatHistory = @json($history);

    function appendMessage(sender, message) {
        const div = document.createElement('div');
        div.classList.add('p-3', 'rounded-3', 'shadow-sm');
        // Sedikit mengurangi max-width karena sekarang layarnya sangat lebar
        div.style.maxWidth = '80%';

        if (sender === 'user') {
            div.classList.add('align-self-end', 'bg-primary', 'text-white', 'chat-bubble-user');
            div.innerHTML = message.replace(/\n/g, '<br>');
        } else {
            div.classList.add('align-self-start', 'bg-white', 'border', 'markdown-content', 'chat-bubble-ai');
            div.innerHTML = marked.parse(message);
        }

        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    if (chatHistory && chatHistory.length > 0) {
        chatHistory.forEach(chat => {
            appendMessage(chat.role, chat.content);
        });
    }

    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const text = chatInput.value.trim();
        if (!text) return;

        appendMessage('user', text);

        chatInput.value = '';
        chatInput.disabled = true;
        sendBtn.disabled = true;

        const loadingId = 'loading-' + Date.now();
        const loadingDiv = document.createElement('div');
        loadingDiv.id = loadingId;
        loadingDiv.classList.add('align-self-start', 'text-muted', 'small', 'fst-italic', 'px-3');
        loadingDiv.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>AI sedang mengetik...';
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