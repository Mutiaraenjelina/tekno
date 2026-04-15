
<div class="toast-container position-fixed top-0 end-0 p-3">
  <div id="primaryToast" class="toast colored-toast bg-primary-transparent" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="toast-header bg-primary text-fixed-white">
      <img class="bd-placeholder-img rounded me-2" src="../assets/images/brand-logos/toggle-dark.png" alt="...">
      <strong class="me-auto">Berhasil</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      {{ session('success') }}
    </div>
  </div>

  <div id="primaryDeleteToast" class="toast colored-toast bg-primary-transparent" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="toast-header bg-primary text-fixed-white">
      <img class="bd-placeholder-img rounded me-2" src="../assets/images/brand-logos/toggle-dark.png" alt="...">
      <strong class="me-auto">Berhasil</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body toast-delete-success">
      
    </div>
  </div>
  <!--<div id="secondaryToast" class="toast colored-toast bg-secondary-transparent" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="toast-header bg-secondary text-fixed-white">
      <img class="bd-placeholder-img rounded me-2" src="../assets/images/brand-logos/toggle-dark.png" alt="...">
      <strong class="me-auto">Vertix</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Your,toast message here.
    </div>
  </div>
  <div id="warningToast" class="toast colored-toast bg-warning-transparent" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="toast-header bg-warning text-fixed-white">
      <img class="bd-placeholder-img rounded me-2" src="../assets/images/brand-logos/toggle-dark.png" alt="...">
      <strong class="me-auto">Vertix</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Your,toast message here.
    </div>
  </div>
  <div id="infoToast" class="toast colored-toast bg-info-transparent" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="toast-header bg-info text-fixed-white">
      <img class="bd-placeholder-img rounded me-2" src="../assets/images/brand-logos/toggle-dark.png" alt="...">
      <strong class="me-auto">Vertix</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Your,toast message here.
    </div>
  </div>
  <div id="successToast" class="toast colored-toast bg-success-transparent" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="toast-header bg-success text-fixed-white">
      <img class="bd-placeholder-img rounded me-2" src="../assets/images/brand-logos/toggle-dark.png" alt="...">
      <strong class="me-auto">Vertix</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Your,toast message here.
    </div>
  </div> -->
  <div id="dangerToast" class="toast colored-toast bg-danger-transparent" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="toast-header bg-danger text-fixed-white">
      <img class="bd-placeholder-img rounded me-2" src="../assets/images/brand-logos/toggle-dark.png" alt="...">
      <strong class="me-auto">Error</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
    {{ session('error') }}
    </div>
  </div>

  <div id="dangerDeleteToast" class="toast colored-toast bg-danger-transparent" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="toast-header bg-danger text-fixed-white">
      <img class="bd-placeholder-img rounded me-2" src="../assets/images/brand-logos/toggle-dark.png" alt="...">
      <strong class="me-auto">Error</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body toast-delete-error">
    
    </div>
  </div>
</div>