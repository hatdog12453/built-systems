@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Chat with ' . $client->full_name . ' - Fitness Coaching')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('coach.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">← Back to Dashboard</a>
    </div>

    <div class="bg-white rounded-lg shadow-lg">
        <!-- Chat Header -->
        <div class="bg-indigo-600 text-white px-6 py-4 rounded-t-lg">
            <h1 class="text-2xl font-bold">Chat with {{ $client->full_name }}</h1>
            <p class="text-indigo-200 text-sm">{{ $client->email }}</p>
        </div>

        <!-- Messages Container -->
        <div id="messagesContainer" class="h-96 overflow-y-auto p-6 space-y-4 bg-gray-50">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_type === 'coach' ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $message->sender_type === 'coach' ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-300 text-gray-900' }}">
                        @if($message->image)
                            <img src="{{ Storage::url($message->image) }}" alt="Message image" class="max-w-full rounded-lg mb-2 cursor-pointer" onclick="openImageModal('{{ Storage::url($message->image) }}')">
                        @endif
                        @if($message->message)
                            <p class="text-sm">{{ $message->message }}</p>
                        @endif
                        <p class="text-xs mt-1 {{ $message->sender_type === 'coach' ? 'text-indigo-200' : 'text-gray-500' }}">
                            {{ $message->created_at->format('M d, Y h:i A') }}
                            @if($message->isRead() && $message->sender_type === 'coach')
                                <span class="ml-2">✓ Read</span>
                            @endif
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    <p>No messages yet. Start the conversation!</p>
                </div>
            @endforelse
        </div>

        <!-- Message Input -->
        <div class="border-t border-gray-200 p-4 bg-gray-50 rounded-b-lg">
            <form id="messageForm" class="space-y-3" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="client_id" value="{{ $client->id }}">
                <div class="space-y-3 w-full">
                    <div class="flex items-center bg-white border border-indigo-100 rounded-full px-4 py-2 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500">
                        <input 
                            type="text" 
                            id="messageInput" 
                            name="message" 
                            placeholder="Type a message..." 
                            class="flex-1 border-0 bg-transparent text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                            maxlength="5000"
                        >
                        <label for="imageInput" class="ml-3 inline-flex items-center justify-center w-11 h-11 rounded-full border border-gray-200 text-gray-500 hover:text-indigo-600 hover:border-indigo-400 transition-colors cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h2l2-3h10l2 3h2a2 2 0 012 2v7a2 2 0 01-2 2h-16a2 2 0 01-2-2V9a2 2 0 012-2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <input 
                                type="file" 
                                id="imageInput" 
                                name="image" 
                                accept="image/*" 
                                class="hidden"
                            >
                        </label>
                    </div>
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold px-8 h-12 rounded-full shadow-lg hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all flex items-center justify-center"
                    >
                        Send
                    </button>
                </div>
                <div id="imagePreview" class="hidden bg-white border border-dashed border-gray-300 rounded-lg p-3">
                    <div class="flex items-center gap-3">
                        <img id="previewImg" src="" alt="Preview" class="max-h-16 rounded-md shadow-sm">
                        <button type="button" id="removeImage" class="text-red-600 hover:text-red-800 text-sm font-medium">Remove</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messagesContainer');
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const clientId = {{ $client->id }};

    console.log('Coach chat initializing for client ID:', clientId);

    // Auto-scroll to bottom
    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Load messages
    function loadMessages() {
        const timestamp = new Date().getTime();
        const url = `{{ route('coach.chat.messages') }}?client_id=${clientId}&t=${timestamp}`;
        
        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            cache: 'no-store'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.messages) {
                renderMessages(data.messages);
            }
        })
        .catch(error => {
            console.error('Error loading messages:', error);
        });
    }

    // Render messages
    function renderMessages(messages) {
        messagesContainer.innerHTML = '';
        if (messages.length === 0) {
            messagesContainer.innerHTML = '<div class="text-center text-gray-500 py-8"><p>No messages yet. Start the conversation!</p></div>';
            return;
        }

        messages.forEach(message => {
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex ${message.sender_type === 'coach' ? 'justify-end' : 'justify-start'}`;
            
            const isRead = message.read_at !== null;
            const readStatus = isRead && message.sender_type === 'coach' ? '<span class="ml-2">✓ Read</span>' : '';
            
            const date = new Date(message.created_at);
            const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) + ' ' + 
                                 date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
            
            const imageHtml = message.image ? `<img src="/storage/${message.image}" alt="Message image" class="max-w-full rounded-lg mb-2 cursor-pointer" onclick="openImageModal('/storage/${message.image}')">` : '';
            const messageHtml = message.message ? `<p class="text-sm">${escapeHtml(message.message)}</p>` : '';
            
            messageDiv.innerHTML = `
                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${message.sender_type === 'coach' ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-300 text-gray-900'}">
                    ${imageHtml}
                    ${messageHtml}
                    <p class="text-xs mt-1 ${message.sender_type === 'coach' ? 'text-indigo-200' : 'text-gray-500'}">
                        ${formattedDate}${readStatus}
                    </p>
                </div>
            `;
            messagesContainer.appendChild(messageDiv);
        });
        scrollToBottom();
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Image preview
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const removeImageBtn = document.getElementById('removeImage');
    let selectedImage = null;

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            selectedImage = file;
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    removeImageBtn.addEventListener('click', function() {
        imageInput.value = '';
        selectedImage = null;
        imagePreview.classList.add('hidden');
        previewImg.src = '';
    });

    // Send message
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        const hasImage = imageInput.files.length > 0;
        
        if (!message && !hasImage) {
            alert('Please enter a message or select an image.');
            return;
        }

        const formData = new FormData(messageForm);
        
        fetch('{{ route("coach.chat.send") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                imageInput.value = '';
                selectedImage = null;
                imagePreview.classList.add('hidden');
                previewImg.src = '';
                loadMessages();
            } else {
                alert('Failed to send message. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
            alert('Failed to send message. Please try again.');
        });
    });

    // Image modal
    function openImageModal(imageSrc) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 cursor-pointer';
        modal.onclick = function() { document.body.removeChild(modal); };
        modal.innerHTML = `<img src="${imageSrc}" alt="Full size" class="max-w-full max-h-full rounded-lg">`;
        document.body.appendChild(modal);
    }

    // Real-time polling - check for new messages every 2 seconds
    setInterval(loadMessages, 2000);

    // Initial load
    loadMessages();
    scrollToBottom();
    
    console.log('Coach chat initialized. Polling every 2 seconds.');
});
</script>
@endsection

