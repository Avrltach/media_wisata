@if($companyProfile->whatsapp)
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $companyProfile->whatsapp) }}"
       target="_blank"
       class="whatsapp-float"
       title="Chat dengan kami via WhatsApp"
       aria-label="Chat WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>
@endif