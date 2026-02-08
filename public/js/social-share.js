function copyLink() {
    const dummy = document.createElement('input');
    const text = window.location.href;

    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand('copy');
    document.body.removeChild(dummy);

    const message = document.getElementById('copyMessage');
    message.style.display = 'block';
    setTimeout(() => {
        message.style.display = 'none';
    }, 3000);
}

function notifyShare(provider) {
    fetch('/social/share-notification', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            provider: provider,
            url: window.location.href
        })
    }).then(response => response.json()).then(data => {
        console.log('Share notification sent:', data);
    }).catch(error => {
        console.error('Error sending share notification:', error);
    });
}

function shareAndNotify(provider) {
    notifyShare(provider);
    // For links, the href will handle the navigation
}
