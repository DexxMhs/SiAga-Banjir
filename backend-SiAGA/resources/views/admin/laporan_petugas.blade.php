<!DOCTYPE html>

<html class="dark" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Validasi Laporan Petugas - Sistem Monitoring Banjir</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&amp;display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600;700;800&amp;display=swap"
      rel="stylesheet"
    />
    <!-- Material Symbols -->
    <link
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
      rel="stylesheet"
    />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Theme Configuration -->
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              primary: "#1f44f9",
              "primary-hover": "#1634c4",
              "background-light": "#f5f6f8",
              "background-dark": "#0f1323",
              "card-dark": "#1a1f36",
              "surface-dark": "#21284a",
              "border-dark": "#2f396a",
              danger: "#ef4444",
              warning: "#f59e0b",
              success: "#10b981",
              "text-secondary": "#8e99cc",
            },
            fontFamily: {
              display: ["Public Sans", "sans-serif"],
              body: ["Noto Sans", "sans-serif"],
            },
            borderRadius: {
              DEFAULT: "0.25rem",
              lg: "0.5rem",
              xl: "0.75rem",
              "2xl": "1rem",
              full: "9999px",
            },
          },
        },
      };
    </script>
    <style>
      .material-symbols-outlined {
        font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
      }
      .material-symbols-filled {
        font-family: "Material Symbols Outlined";
        font-weight: normal;
        font-style: normal;
        font-size: 24px;
        line-height: 1;
        letter-spacing: normal;
        text-transform: none;
        display: inline-block;
        white-space: nowrap;
        word-wrap: normal;
        direction: ltr;
        -webkit-font-feature-settings: "liga";
        -webkit-font-smoothing: antialiased;
        font-variation-settings: "FILL" 1, "wght" 400, "GRAD" 0, "opsz" 24;
      }
      /* Hide scrollbar for clean look */
      .no-scrollbar::-webkit-scrollbar {
        display: none;
      }
      .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
      }
    </style>
  </head>
  <body
    class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-white antialiased overflow-hidden"
  >
    <div class="flex h-screen w-full">
      <!-- Sidebar Navigation -->
      <aside
        class="hidden w-72 flex-col border-r border-border-dark bg-background-dark md:flex"
      >
        <div class="flex flex-col h-full p-4">
          <!-- Header Logo -->
          <div class="mb-8 flex items-center gap-3 px-2 pt-2">
            <div
              class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary text-white"
            >
              <span class="material-symbols-outlined">water_drop</span>
            </div>
            <div class="flex flex-col">
              <h1 class="text-base font-bold leading-tight text-white">
                FloodMon
              </h1>
              <p class="text-xs font-normal text-text-secondary">Admin Panel</p>
            </div>
          </div>
          <!-- Navigation Links -->
          <nav class="flex flex-1 flex-col gap-2 overflow-y-auto no-scrollbar">
            <a
              class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-secondary hover:bg-surface-dark hover:text-white transition-colors"
              href="#"
            >
              <span class="material-symbols-outlined">dashboard</span>
              <span class="text-sm font-medium">Dashboard</span>
            </a>
            <div class="pt-2 pb-1">
              <p
                class="px-3 text-xs font-semibold uppercase tracking-wider text-text-secondary/60"
              >
                Manajemen
              </p>
            </div>
            <a
              class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-secondary hover:bg-surface-dark hover:text-white transition-colors"
              href="#"
            >
              <span class="material-symbols-outlined">map</span>
              <span class="text-sm font-medium">Pos Pantau</span>
            </a>
            <a
              class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-secondary hover:bg-surface-dark hover:text-white transition-colors"
              href="#"
            >
              <span class="material-symbols-outlined">badge</span>
              <span class="text-sm font-medium">Petugas</span>
            </a>
            <div class="pt-2 pb-1">
              <p
                class="px-3 text-xs font-semibold uppercase tracking-wider text-text-secondary/60"
              >
                Laporan
              </p>
            </div>
            <a
              class="flex items-center gap-3 rounded-lg bg-surface-dark border-l-4 border-primary px-3 py-2.5 text-white transition-colors"
              href="#"
            >
              <span class="material-symbols-filled text-primary"
                >assignment</span
              >
              <span class="text-sm font-medium">Laporan Petugas</span>
            </a>
            <a
              class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-secondary hover:bg-surface-dark hover:text-white transition-colors"
              href="#"
            >
              <span class="material-symbols-outlined">campaign</span>
              <span class="text-sm font-medium">Laporan Masyarakat</span>
            </a>
            <a
              class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-secondary hover:bg-surface-dark hover:text-white transition-colors"
              href="#"
            >
              <span class="material-symbols-outlined">thunderstorm</span>
              <span class="text-sm font-medium">Potensi Banjir</span>
            </a>
            <a
              class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-text-secondary hover:bg-surface-dark hover:text-white transition-colors"
              href="#"
            >
              <span class="material-symbols-outlined">folder_open</span>
              <span class="text-sm font-medium">Rekap Laporan</span>
            </a>
          </nav>
          <!-- Footer Profile -->
          <div class="mt-auto border-t border-border-dark pt-4">
            <button
              class="flex w-full items-center gap-3 rounded-lg px-2 py-2 text-left hover:bg-surface-dark transition-colors"
            >
              <div
                class="h-9 w-9 overflow-hidden rounded-full bg-slate-700"
                data-alt="profile image of admin user"
                style="
                  background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBRNibd_p65dOlS0tK03m9Rf3c8Dw4VG43rYHWLc3NGhAEoAnH8S8JD6WzHyBjC-h6kRw54I9LbYBH8IXgR087gLsy4LW4AnyHd2MiPx_s0yDzxMEFUtKplA4bN5syeK6H-Mjzsr9W-iCxd2AeQh-1rSICsuyq37tCiTtOkU7C9QKaR5kge_Z4IGswopPb_80pGDboi0HJxhNtIJiux7V1C9PIbTId327pfNIUj6hiHH1G6EHVBuVcR5hYavlF5-eXI92J6anCXRnqP');
                  background-size: cover;
                "
              ></div>
              <div class="flex flex-1 flex-col overflow-hidden">
                <p class="truncate text-sm font-medium text-white">
                  Admin Utama
                </p>
                <p class="truncate text-xs text-text-secondary">
                  superadmin@floodmon.id
                </p>
              </div>
              <span class="material-symbols-outlined text-text-secondary"
                >logout</span
              >
            </button>
          </div>
        </div>
      </aside>
      <!-- Main Content Area -->
      <main class="flex h-full flex-1 flex-col overflow-hidden relative">
        <!-- Top Header -->
        <header
          class="flex h-16 items-center justify-between border-b border-border-dark bg-background-dark/80 px-6 backdrop-blur-md"
        >
          <div class="flex items-center gap-4">
            <!-- Mobile Menu Toggle -->
            <button class="flex md:hidden text-text-secondary hover:text-white">
              <span class="material-symbols-outlined">menu</span>
            </button>
            <!-- Breadcrumbs -->
            <nav class="flex items-center text-sm font-medium">
              <a
                class="text-text-secondary hover:text-white transition-colors"
                href="#"
                >Laporan Petugas</a
              >
              <span class="mx-2 text-text-secondary">/</span>
              <span class="text-white">Validasi Laporan #FL-2023-0891</span>
            </nav>
          </div>
          <div class="flex items-center gap-4">
            <button
              class="relative rounded-full p-2 text-text-secondary hover:bg-surface-dark hover:text-white transition-colors"
            >
              <span class="material-symbols-outlined">notifications</span>
              <span
                class="absolute right-2 top-2 h-2 w-2 rounded-full bg-danger"
              ></span>
            </button>
            <!-- Avatar Top Right -->
            <div
              class="h-8 w-8 rounded-full bg-gray-600 border border-border-dark"
              data-alt="Admin avatar small"
              style="
                background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuB1DAhbtDNhUtCCNo0X-zd_S1z6-lVq--le_SBQnBsz_JXdJuk-_fG0RR_2UGnX8Vat5HdvVVqeTTqdjMzMtrQMGtNMdhEK7sUEUBfCXx0cgN02jEvXocQ-LdoCeYXsa1IeDT4Wq9bxvJoINPc1M6cpiWBwAHG7GDvT6j0z4jVLkgJqs8ojrJWGnKVCkE1ob3zuZUnKkR3orNifmmi2Q-M8YPeM2USSX_kdrhPKg7OSYIdcPj7pO76IFmvrij2zH4YhnMQqeUm9UaWm');
                background-size: cover;
              "
            ></div>
          </div>
        </header>
        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-6 lg:p-10 no-scrollbar">
          <div class="mx-auto max-w-7xl">
            <!-- Page Title & Status -->
            <div
              class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-start"
            >
              <div class="flex flex-col gap-1">
                <div class="flex items-center gap-3">
                  <h1 class="text-3xl font-bold text-white tracking-tight">
                    Validasi Laporan #FL-2023-0891
                  </h1>
                  <span
                    class="rounded-full bg-warning/20 px-3 py-1 text-xs font-semibold text-warning border border-warning/30"
                    >Menunggu Validasi</span
                  >
                </div>
                <p class="text-text-secondary">
                  Ditinjau dari Petugas:
                  <span class="text-white font-medium"
                    >Budi Santoso (ID: OFF-002)</span
                  >
                </p>
              </div>
              <div class="flex gap-2">
                <button
                  class="flex items-center gap-2 rounded-lg border border-border-dark bg-surface-dark px-4 py-2 text-sm font-medium text-white hover:bg-border-dark transition-colors"
                >
                  <span class="material-symbols-outlined text-sm">history</span>
                  Riwayat
                </button>
                <button
                  class="flex items-center gap-2 rounded-lg border border-border-dark bg-surface-dark px-4 py-2 text-sm font-medium text-white hover:bg-border-dark transition-colors"
                >
                  <span class="material-symbols-outlined text-sm">print</span>
                  Cetak
                </button>
              </div>
            </div>
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
              <!-- Left Column: Report Details (2/3 width) -->
              <div class="flex flex-col gap-6 lg:col-span-2">
                <!-- Key Metrics Cards -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                  <div
                    class="rounded-xl border border-border-dark bg-card-dark p-5 shadow-sm"
                  >
                    <div class="mb-2 flex items-center justify-between">
                      <p class="text-sm font-medium text-text-secondary">
                        Ketinggian Air
                      </p>
                      <span class="material-symbols-outlined text-primary"
                        >water</span
                      >
                    </div>
                    <p class="text-3xl font-bold text-white">
                      850
                      <span class="text-lg font-normal text-text-secondary"
                        >cm</span
                      >
                    </p>
                    <div
                      class="mt-2 flex items-center gap-2 text-xs text-warning"
                    >
                      <span class="material-symbols-outlined text-sm"
                        >trending_up</span
                      >
                      <span>Naik 10cm dari 1 jam lalu</span>
                    </div>
                  </div>
                  <div
                    class="rounded-xl border border-border-dark bg-card-dark p-5 shadow-sm"
                  >
                    <div class="mb-2 flex items-center justify-between">
                      <p class="text-sm font-medium text-text-secondary">
                        Status Bahaya
                      </p>
                      <span class="material-symbols-outlined text-warning"
                        >warning</span
                      >
                    </div>
                    <p class="text-3xl font-bold text-warning">Siaga 2</p>
                    <div class="mt-2 text-xs text-text-secondary">
                      Perlu pemantauan intensif
                    </div>
                  </div>
                </div>
                <!-- Detailed Info -->
                <div
                  class="rounded-xl border border-border-dark bg-card-dark p-6 shadow-sm"
                >
                  <h2 class="mb-4 text-lg font-semibold text-white">
                    Detail Laporan
                  </h2>
                  <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="space-y-4">
                      <div
                        class="flex flex-col gap-1 border-b border-border-dark pb-3"
                      >
                        <span
                          class="text-xs font-medium uppercase text-text-secondary"
                          >Lokasi Pos Pantau</span
                        >
                        <span class="text-base font-medium text-white"
                          >Pintu Air Manggarai</span
                        >
                      </div>
                      <div
                        class="flex flex-col gap-1 border-b border-border-dark pb-3"
                      >
                        <span
                          class="text-xs font-medium uppercase text-text-secondary"
                          >Waktu Laporan</span
                        >
                        <span class="text-base font-medium text-white"
                          >24 Oct 2023, 14:30 WIB</span
                        >
                      </div>
                    </div>
                    <div class="space-y-4">
                      <div
                        class="flex flex-col gap-1 border-b border-border-dark pb-3"
                      >
                        <span
                          class="text-xs font-medium uppercase text-text-secondary"
                          >Koordinat</span
                        >
                        <span
                          class="text-base font-medium text-white flex items-center gap-2"
                        >
                          -6.2088, 106.8456
                          <a
                            class="text-primary hover:underline text-xs ml-2"
                            href="#"
                            >Buka Peta</a
                          >
                        </span>
                      </div>
                      <div
                        class="flex flex-col gap-1 border-b border-border-dark pb-3"
                      >
                        <span
                          class="text-xs font-medium uppercase text-text-secondary"
                          >Cuaca</span
                        >
                        <span
                          class="text-base font-medium text-white flex items-center gap-2"
                        >
                          <span class="material-symbols-outlined text-sm"
                            >cloudy</span
                          >
                          Berawan
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="mt-4 pt-2">
                    <span
                      class="text-xs font-medium uppercase text-text-secondary"
                      >Catatan Petugas</span
                    >
                    <p
                      class="mt-2 text-sm leading-relaxed text-slate-300 bg-surface-dark p-3 rounded-lg border border-border-dark"
                    >
                      Debit air mengalami peningkatan signifikan dalam 30 menit
                      terakhir karena kiriman dari hulu (Bogor). Sampah menumpuk
                      di pintu 3 menyebabkan aliran sedikit terhambat. Tim
                      sedang melakukan pembersihan manual.
                    </p>
                  </div>
                </div>
                <!-- Media Evidence -->
                <div
                  class="rounded-xl border border-border-dark bg-card-dark p-6 shadow-sm"
                >
                  <h2
                    class="mb-4 text-lg font-semibold text-white flex items-center justify-between"
                  >
                    Bukti Foto &amp; Video
                    <span
                      class="text-xs font-normal text-text-secondary bg-surface-dark px-2 py-1 rounded"
                      >3 file terlampir</span
                    >
                  </h2>
                  <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                    <div
                      class="group relative aspect-square cursor-pointer overflow-hidden rounded-lg bg-surface-dark border border-border-dark"
                    >
                      <div
                        class="h-full w-full bg-cover bg-center transition-transform duration-300 group-hover:scale-110"
                        data-alt="High angle photo of river water level at flood gate"
                        style="
                          background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCIbTNKowaZ9zM6jjL7T5Ai-VTXfY2W4Bq2rzMzURht2epiIRcpdMsEE5toQd413NjLBxKTZFGFiHJ8_fg7AG10ZQ6QXIzOvyYcTV7YLWCGs6WkXpWfMFI3ZbsvB99MR6Kjr8UpETMbX1pCh3EtY-oTLjSF71-SYpFc6oPfv2GQNmDTUlPq5cs19vPWVWJklUv7mLmD71BHWAaF76vav6phiasxteAPGY2kk8CIilqFvxbQIPOBAK7I7GegBYUgqNHOaXpqe8Tg0H1E');
                        "
                      ></div>
                      <div
                        class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100"
                      >
                        <span
                          class="material-symbols-outlined text-white text-3xl"
                          >visibility</span
                        >
                      </div>
                    </div>
                    <div
                      class="group relative aspect-square cursor-pointer overflow-hidden rounded-lg bg-surface-dark border border-border-dark"
                    >
                      <div
                        class="h-full w-full bg-cover bg-center transition-transform duration-300 group-hover:scale-110"
                        data-alt="Close up photo of water measurement gauge"
                        style="
                          background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCFKVkywOaGu5duh8HoL895HcJvc6DM5LRd5_5W_Zq-Hxrpvi0yz2X6eWV2stgjW4Jmr3Pvakd1OuwVugKsNCI1JBAQJni7j45mYfWE6oZi_YW1P-BuZ9dRMcV7BX3smd35K42Ph9Uk7TA8V3UiK8QHsJ6ugPeCYCyGEVMQ7pg3Dg6AUftEQ4hrdp5naM_StXZ81whbXgm4FFVl7PzmQn7TUHRRAldD2zq_x5ovkXy0bnf47PAOzPlZh3phe-3lSE6euVj1zl9Ey068');
                        "
                      ></div>
                      <div
                        class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100"
                      >
                        <span
                          class="material-symbols-outlined text-white text-3xl"
                          >visibility</span
                        >
                      </div>
                    </div>
                    <div
                      class="group relative aspect-square cursor-pointer overflow-hidden rounded-lg bg-surface-dark border border-border-dark"
                    >
                      <div
                        class="h-full w-full bg-cover bg-center opacity-80"
                        data-alt="Thumbnail for video of river flow"
                        style="
                          background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuD16iok8dLhVhZmiECYOylZUP1jYiIOobAYdLNdTSM9PdcKt4rZ_x4gchq0UeFoIz55csoh9i_TGaHudRS566VjI7USbAEyqWyCF1l-9UqPuUq0wk7n7PWwLV2abtfP6HzXk0JtFMr_xyB9cklsqmEqHLJ9zr1lw0nJI98hEMpHujjHZ28FyAwimcJwT9f5FUnx1hO2Fx3yU4R37WCEsYyze91GawpdwChxH0rAgvrtigmGjJURe3ftJoNcb5yAQez5z7Z3O7A_F2s0');
                        "
                      ></div>
                      <div
                        class="absolute inset-0 flex items-center justify-center bg-black/20"
                      >
                        <div
                          class="flex h-12 w-12 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm border border-white/40 shadow-lg group-hover:scale-110 transition-transform"
                        >
                          <span
                            class="material-symbols-filled text-white text-3xl ml-1"
                            >play_arrow</span
                          >
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Right Column: Map & Action (1/3 width) -->
              <div class="flex flex-col gap-6 lg:col-span-1">
                <!-- Map Preview -->
                <div
                  class="rounded-xl border border-border-dark bg-card-dark overflow-hidden shadow-sm"
                >
                  <div
                    class="p-4 border-b border-border-dark flex justify-between items-center"
                  >
                    <h3 class="font-semibold text-white">Lokasi Kejadian</h3>
                    <span
                      class="text-xs text-text-secondary flex items-center gap-1"
                      ><span class="material-symbols-outlined text-sm"
                        >my_location</span
                      >
                      Akurat 5m</span
                    >
                  </div>
                  <div class="relative h-48 w-full bg-slate-800">
                    <div
                      class="h-full w-full bg-cover bg-center opacity-70 grayscale hover:grayscale-0 transition-all duration-500"
                      data-alt="Map view showing river location in Jakarta"
                      data-location="Jakarta, Indonesia"
                      style="
                        background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDPMycUVVjT8mKgwy_vsiQIObmHzfq4XPHEwGJgUvq755m4Uut1olwf7334L3hrr87598-ho1Frcam_xjbBjDlQHm1IVPMEOvxL_yFodoWHS4_GljXr1O7gXoaC8Hgyik3ErpsyD0wXGv5x__WqSkQsWqmqB4amkzGZGWSfUWCynN3FF7MFgnjDwQx6qpuqm46Fc4nlhqZKPT5SksglM8SoiL1_XffwcxentLanOGLF8iANfqbKgrtoxAO8zvaJdlm2K5saKABUTPLy');
                        background-color: #1e293b;
                      "
                    >
                      <!-- Fallback visual if map image doesn't load/exist in this context -->
                      <div
                        class="absolute inset-0 bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center"
                      >
                        <div class="text-center p-4">
                          <span
                            class="material-symbols-outlined text-slate-500 text-4xl mb-2"
                            >map</span
                          >
                          <p class="text-xs text-slate-500">Peta Lokasi</p>
                        </div>
                      </div>
                    </div>
                    <!-- Pin Marker -->
                    <div
                      class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-full transform"
                    >
                      <span
                        class="material-symbols-filled text-danger text-4xl drop-shadow-lg"
                        >location_on</span
                      >
                    </div>
                  </div>
                </div>
                <!-- Action Panel (Sticky on larger screens if needed) -->
                <div
                  class="sticky top-6 rounded-xl border border-border-dark bg-card-dark p-6 shadow-lg shadow-black/20"
                >
                  <h3 class="mb-4 text-lg font-semibold text-white">
                    Aksi Validasi
                  </h3>
                  <form class="flex flex-col gap-4">
                    <div class="space-y-2">
                      <label
                        class="text-sm font-medium text-text-secondary"
                        for="feedback"
                        >Catatan Validasi</label
                      >
                      <textarea
                        class="w-full rounded-lg border-border-dark bg-surface-dark p-3 text-sm text-white placeholder-slate-500 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none"
                        id="feedback"
                        placeholder="Tuliskan alasan penolakan atau instruksi revisi (opsional untuk persetujuan)..."
                        rows="4"
                      ></textarea>
                    </div>
                    <div class="mt-2 flex flex-col gap-3">
                      <button
                        class="group flex w-full items-center justify-center gap-2 rounded-lg bg-primary py-3 px-4 text-sm font-semibold text-white shadow-md hover:bg-primary-hover focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-surface-dark transition-all"
                        type="button"
                      >
                        <span
                          class="material-symbols-outlined transition-transform group-hover:-translate-y-0.5"
                          >check_circle</span
                        >
                        Setujui Laporan
                      </button>
                      <div class="grid grid-cols-2 gap-3">
                        <button
                          class="group flex w-full items-center justify-center gap-2 rounded-lg border border-warning/30 bg-warning/10 py-2.5 px-3 text-sm font-medium text-warning hover:bg-warning/20 transition-all"
                          type="button"
                        >
                          <span class="material-symbols-outlined text-lg"
                            >edit_note</span
                          >
                          Minta Revisi
                        </button>
                        <button
                          class="group flex w-full items-center justify-center gap-2 rounded-lg border border-danger/30 bg-danger/10 py-2.5 px-3 text-sm font-medium text-danger hover:bg-danger/20 transition-all"
                          type="button"
                        >
                          <span class="material-symbols-outlined text-lg"
                            >cancel</span
                          >
                          Tolak
                        </button>
                      </div>
                    </div>
                  </form>
                  <div class="mt-6 pt-4 border-t border-border-dark">
                    <div class="flex items-start gap-3">
                      <div
                        class="mt-1 h-2 w-2 rounded-full bg-success shrink-0"
                      ></div>
                      <div>
                        <p class="text-xs font-medium text-white">
                          Sistem Otomatis
                        </p>
                        <p class="text-xs text-text-secondary mt-0.5">
                          Data valid. Tidak terdeteksi anomali pada sensor di
                          pos pantau terkait.
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>
