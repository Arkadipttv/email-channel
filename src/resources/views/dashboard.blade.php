<!DOCTYPE html>
<html>
<head>
    <title>Email Dashboard</title>
</head>
<body style="font-family: Arial; padding: 30px;">

<h2>📧 Email Dashboard</h2>

<!-- Send Email -->
<form id="sendForm">
    <input type="email" id="to" placeholder="To" required><br><br>
    <input type="text" id="subject" placeholder="Subject" required><br><br>
    <textarea id="body" placeholder="Message"></textarea><br><br>
    <button type="submit">Send</button>
</form>

<hr>

<h3>📨 Emails</h3>
<div id="emails"></div>

<script>
async function loadEmails() {
    let res = await fetch('/email-channel/emails');
    let data = await res.json();

    let html = '';
    data.forEach(e => {
        html += `
        <div style="border:1px solid #ccc; padding:10px; margin:10px;">
            <b>${e.from}</b> → ${e.to}<br>
            ${e.content}<br>
            <span style="color:${e.status === 'sent' ? 'green' : 'maroon'}">
                ${e.status}
            </span><br>
            ${e.timestamp ?? ''}
        </div>`;
    });

    document.getElementById('emails').innerHTML = html;
}

setInterval(loadEmails, 2000);

document.getElementById('sendForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    await fetch('/email-channel/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            to: document.getElementById('to').value,
            subject: document.getElementById('subject').value,
            body: document.getElementById('body').value
        })
    });

    loadEmails();
});
</script>

</body>
</html>