@extends('layouts.kai')
@section('content')
<div class="container mx-auto p-4 max-w-3xl">
    <div class="bg-white rounded-xl shadow-lg flex flex-col h-[700px] border border-gray-100">

        <div class="bg-indigo-600 text-white p-4 rounded-t-xl flex justify-between items-center">
            <h3 class="text-xl font-bold flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                AI Asisten Gudang
            </h3>
            <button id="clear-btn" class="text-sm bg-indigo-700 hover:bg-indigo-800 px-3 py-1 rounded transition">
                Reset Obrolan
            </button>
        </div>

        <div id="chat-box" class="flex-1 p-6 overflow-y-auto bg-gray-50 flex flex-col gap-4">
            <div class="bg-indigo-100 text-indigo-900 p-4 rounded-2xl rounded-tl-none max-w-[85%] self-start shadow-sm">
                Halo! Saya asisten pintar untuk SaaS Inventaris Anda. Ada yang bisa saya bantu hari ini?
            </div>

            @foreach($history as $chat)
                @if($chat['role'] === 'user')
                    <div class="bg-indigo-600 text-white p-4 rounded-2xl rounded-tr-none max-w-[85%] self-end shadow-sm">
                        {!! nl2br(e($chat['content'])) !!}
                    </div>
                @else
                    <div class="bg-white text-gray-800 border border-gray-200 p-4 rounded-2xl rounded-tl-none max-w-[85%] self-start shadow-sm markdown-body">
                        {{-- Idealnya Anda menggunakan library parser markdown JS di frontend, tapi untuk sementara kita tampilkan text --}}
                        {!! nl2br(e($chat['content'])) !!}
                    </div>
                @endif
            @endforeach
        </div>

        <div class="p-4 bg-white border-t border-gray-100 rounded-b-xl">
            <form id="chat-form" class="flex gap-3">
                <input type="text" id="chat-input" class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" placeholder="Tanyakan soal stok, barang, atau fitur gudang..." autocomplete="off" required>
                <button type="submit" id="send-btn" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 font-semibold transition flex items-center gap-2">
                    Kirim
                </button>
            </form>
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

    // Auto-scroll ke bawah saat halaman dimuat
    chatBox.scrollTop = chatBox.scrollHeight;

    function appendMessage(sender, message) {
        const div = document.createElement('div');
        div.classList.add('p-4', 'rounded-2xl', 'max-w-[85%]', 'shadow-sm', 'whitespace-pre-wrap');

        if (sender === 'user') {
            div.classList.add('bg-indigo-600', 'text-white', 'self-end', 'rounded-tr-none');
        } else {
            div.classList.add('bg-white', 'text-gray-800', 'border', 'border-gray-200', 'self-start', 'rounded-tl-none');
        }

        div.innerHTML = message;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Handle form submit
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const text = chatInput.value.trim();
        if (!text) return;

        appendMessage('user', text);
        chatInput.value = '';
        chatInput.disabled = true;
        sendBtn.disabled = true;

        // Indikator Loading
        const loadingId = 'loading-' + Date.now();
        const loadingDiv = document.createElement('div');
        loadingDiv.id = loadingId;
        loadingDiv.classList.add('text-sm', 'text-gray-500', 'self-start', 'italic', 'animate-pulse', 'px-4');
        loadingDiv.innerText = 'AI sedang memproses...';
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
                appendMessage('ai', data.error || 'Terjadi kesalahan sistem.');
            }
        } catch (error) {
            document.getElementById(loadingId).remove();
            appendMessage('ai', 'Koneksi gagal. Silakan periksa jaringan Anda.');
        } finally {
            chatInput.disabled = false;
            sendBtn.disabled = false;
            chatInput.focus();
        }
    });

    // Handle reset memori
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