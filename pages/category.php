<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="mainContent">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-sm-7">
          <h1 class="m-0 text-dark">Category Management</h1>
          <small class="text-muted">Organize inventory categories with a cleaner workflow.</small>
        </div>
        <div class="col-sm-5">
          <ol class="breadcrumb float-sm-right mb-0">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Category</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <style>
        :root {
          --cat-border: #e5eaf4;
          --cat-soft-bg: linear-gradient(145deg, #f8fbff 0%, #eef4ff 100%);
          --cat-ink: #0f172a;
          --cat-muted: #64748b;
          --cat-brand: #1d4ed8;
          --cat-shadow: 0 16px 34px rgba(15, 23, 42, 0.06);
        }

        .cat-hero {
          border: 1px solid var(--cat-border);
          border-radius: 14px;
          padding: 16px;
          margin-bottom: 14px;
          background: var(--cat-soft-bg);
          box-shadow: var(--cat-shadow);
        }

        .cat-hero-title {
          margin: 0;
          color: var(--cat-ink);
          font-weight: 700;
          font-size: 1.05rem;
        }

        .cat-hero-sub {
          color: var(--cat-muted);
          margin: 4px 0 0;
          font-size: 0.86rem;
        }

        .cat-toolbar {
          display: flex;
          flex-wrap: wrap;
          align-items: center;
          gap: 10px;
          margin-top: 12px;
        }

        .cat-search {
          position: relative;
          flex: 1 1 280px;
          min-width: 220px;
        }

        .cat-search i {
          position: absolute;
          left: 11px;
          top: 50%;
          transform: translateY(-50%);
          color: #94a3b8;
          font-size: 0.84rem;
        }

        .cat-search input {
          width: 100%;
          border: 1px solid #dbe4f2;
          border-radius: 9px;
          padding: 9px 12px 9px 32px;
          font-size: 0.86rem;
          color: var(--cat-ink);
          background: #fff;
          outline: none;
        }

        .cat-search input:focus {
          border-color: #93c5fd;
          box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .cat-kpi {
          display: inline-flex;
          align-items: center;
          gap: 6px;
          border-radius: 999px;
          padding: 7px 11px;
          border: 1px solid #cfe0ff;
          background: #eaf2ff;
          color: #1e3a8a;
          font-size: 0.78rem;
          font-weight: 700;
        }

        .cat-card {
          border: 1px solid var(--cat-border);
          border-radius: 14px;
          box-shadow: var(--cat-shadow);
        }

        .cat-card .card-header {
          background: #fff;
          border-bottom: 1px solid var(--cat-border);
          padding: 13px 16px;
        }

        .cat-card .card-title {
          margin: 0;
          color: var(--cat-ink);
          font-size: 0.95rem;
          font-weight: 700;
        }

        .cat-card .card-body {
          padding: 14px;
        }

        .cat-table-wrap {
          position: relative;
          border: 1px solid #e8edf6;
          border-radius: 11px;
          overflow: hidden;
          background: #fff;
          transition: opacity 0.2s ease;
        }

        #catagoryTable_wrapper {
          padding: 10px;
        }

        #catagoryTable {
          width: 100% !important;
        }

        #catagoryTable thead th {
          background: #f8fbff;
          color: #475569;
          font-size: 0.8rem;
          font-weight: 700;
          border-bottom: 1px solid #e7eef9;
        }

        #catagoryTable tbody td {
          font-size: 0.86rem;
          color: #0f172a;
          vertical-align: middle;
        }

        .cat-skeleton {
          display: none;
          gap: 9px;
          padding: 14px;
          position: absolute;
          inset: 0;
          background: rgba(255, 255, 255, 0.95);
          z-index: 3;
        }

        .cat-skeleton-line {
          height: 42px;
          border-radius: 9px;
          background: linear-gradient(100deg, #e9effa 12%, #f7faff 45%, #e9effa 78%);
          background-size: 220% 100%;
          animation: catShimmer 1.05s linear infinite;
        }

        @keyframes catShimmer {
          0% { background-position: 200% 0; }
          100% { background-position: -200% 0; }
        }

        @media (max-width: 767.98px) {
          .cat-card .card-body {
            padding: 10px;
          }

          #catagoryTable_wrapper {
            padding: 8px;
          }
        }
      </style>

      <div class="cat-hero">
        <h2 class="cat-hero-title">Inventory Categories</h2>
        <p class="cat-hero-sub">Organize and manage supply groups for easier stock tracking and reporting.</p>
        <div class="cat-toolbar">
          <div class="cat-search">
            <i class="fas fa-search" aria-hidden="true"></i>
            <input id="categoryQuickSearch" type="search" placeholder="Search supply category..." aria-label="Search category">
          </div>
          <span class="cat-kpi" id="categoryTotalCount"><i class="fas fa-layer-group"></i> Loading categories...</span>
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".catagoryModal">
            <i class="fas fa-plus mr-1"></i> New Category
          </button>
        </div>
      </div>

      <div class="card cat-card">
        <div class="card-header d-flex justify-content-between align-items-center" style="gap:8px;">
          <h3 class="card-title">Category Table</h3>
          <small class="text-muted">Server-side paginated</small>
        </div>
        <div class="card-body">
          <div class="cat-table-wrap" id="categoryTableWrap">
            <div class="cat-skeleton" id="categorySkeleton" aria-hidden="true">
              <div class="cat-skeleton-line"></div>
              <div class="cat-skeleton-line"></div>
              <div class="cat-skeleton-line"></div>
              <div class="cat-skeleton-line"></div>
              <div class="cat-skeleton-line"></div>
              <div class="cat-skeleton-line"></div>
            </div>

            <div class="table-responsive">
              <table id="catagoryTable" class="display dataTable text-center">
                <thead>
                  <tr>
                    <th>SI</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
(function () {
  function bootCategoryEnhancement() {
    if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.DataTable) {
      setTimeout(bootCategoryEnhancement, 60);
      return;
    }

    const $ = window.jQuery;
    const $table = $('#catagoryTable');
    if (!$table.length) return;

    const skeleton = document.getElementById('categorySkeleton');
    const tableWrap = document.getElementById('categoryTableWrap');
    const countChip = document.getElementById('categoryTotalCount');
    const quickSearch = document.getElementById('categoryQuickSearch');

    function showSkeleton() {
      if (skeleton) skeleton.style.display = 'grid';
      if (tableWrap) tableWrap.style.opacity = '0.88';
    }

    function hideSkeleton() {
      if (skeleton) skeleton.style.display = 'none';
      if (tableWrap) tableWrap.style.opacity = '1';
    }

    function updateCountFromApi(json) {
      if (!countChip) return;
      const total = Number((json && json.iTotalRecords) || 0);
      countChip.innerHTML = '<i class="fas fa-layer-group"></i> ' + total.toLocaleString() + ' categories';
    }

    showSkeleton();

    $table.on('preXhr.dt', function () {
      showSkeleton();
    });

    $table.on('xhr.dt', function (e, settings, json) {
      updateCountFromApi(json || {});
      hideSkeleton();
    });

    $table.on('draw.dt error.dt init.dt', function () {
      hideSkeleton();
    });

    if (quickSearch) {
      quickSearch.addEventListener('input', function (event) {
        const value = event.target.value || '';
        if ($.fn.DataTable.isDataTable('#catagoryTable')) {
          $table.DataTable().search(value).draw();
        }
      });
    }

    setTimeout(function () {
      if ($.fn.DataTable.isDataTable('#catagoryTable') && countChip) {
        const api = $table.DataTable();
        const info = api.page.info();
        if (info && typeof info.recordsTotal === 'number') {
          countChip.innerHTML = '<i class="fas fa-layer-group"></i> ' + Number(info.recordsTotal).toLocaleString() + ' categories';
        }
      }
      hideSkeleton();
    }, 450);
  }

  bootCategoryEnhancement();
})();
</script>
