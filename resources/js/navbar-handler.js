const menuBtn = document.getElementById("menu-button");
const closeBtn = document.getElementById("close-button");
const mobileMenu = document.getElementById("mobile-menu");
const profileButton = document.getElementById("profile-button");
const profileMenu = document.getElementById("profile-menu");

const inboxButton = document.getElementById("inbox-button");
const inboxMenu = document.getElementById("inbox-menu");
const inboxList = document.getElementById("inbox-list");
const inboxBadge = document.getElementById("inbox-badge");

menuBtn.addEventListener("click", () => {
    mobileMenu.classList.remove("hidden");
    mobileMenu.classList.add("flex");
});

closeBtn.addEventListener("click", () => {
    mobileMenu.classList.remove("flex");
    mobileMenu.classList.add("hidden");
});

// Toggle dropdown saat tombol diklik
profileButton.addEventListener("click", () => {
    profileMenu.classList.toggle("hidden");
});

// Tutup dropdown saat klik di luar modal
document.addEventListener("click", (event) => {
    if (
        !profileButton.contains(event.target) &&
        !profileMenu.contains(event.target)
    ) {
        profileMenu.classList.add("hidden");
    }
    if (
        !inboxButton.contains(event.target) &&
        !inboxMenu.contains(event.target)
    ) {
        inboxMenu.classList.add("hidden");
    }
});

async function fetchNotifications() {
    try {
        // Endpoint API ini perlu Anda buat
        const response = await axios.get("/api/notifikasi/saya");
        const notifications = response.data.data;

        inboxList.innerHTML = ""; // Kosongkan daftar

        if (notifications.length === 0) {
            inboxList.innerHTML =
                '<p class="p-4 text-center text-sm text-gray-500">Tidak ada notifikasi.</p>';
        } else {
            notifications.forEach((notif) => {
                const isUnread = !notif.dibaca_pada;
                const notifLink = document.createElement("a");

                // Tentukan link berdasarkan tipe notifikasi
                if (notif.data && notif.data.id_lomba) {
                    // Semua notifikasi admin lomba akan mengarah ke detail lomba
                    notifLink.href = `/dashboard/adminlomba/lomba/detail/${notif.data.id_lomba}`;
                } else {
                    notifLink.href = "#"; // Fallback
                }

                notifLink.className = `block px-4 py-3 hover:bg-gray-100 ${
                    isUnread ? "bg-blue-50" : ""
                }`;
                notifLink.innerHTML = `
                            <p class="font-semibold text-sm text-gray-800">${
                                notif.judul
                            }</p>
                            <p class="text-xs text-gray-600">${notif.pesan}</p>
                            <p class="text-xs text-gray-400 mt-1">${new Date(
                                notif.created_at
                            ).toLocaleString("id-ID")}</p>
                        `;
                inboxList.appendChild(notifLink);
            });
        }

        // Update badge notifikasi yang belum dibaca
        const unreadCount = notifications.filter((n) => !n.dibaca_pada).length;
        if (unreadCount > 0) {
            inboxBadge.textContent = unreadCount;
            inboxBadge.classList.remove("hidden");
        } else {
            inboxBadge.classList.add("hidden");
        }
    } catch (error) {
        console.error("Gagal mengambil notifikasi:", error);
        inboxList.innerHTML =
            '<p class="p-4 text-center text-sm text-red-500">Gagal memuat notifikasi.</p>';
    }
}

// Event listener untuk tombol inbox
inboxButton.addEventListener("click", async (e) => {
    e.stopPropagation(); // Mencegah klik menyebar ke document
    inboxMenu.classList.toggle("hidden");
    profileMenu.classList.add("hidden"); // Tutup profil saat inbox dibuka

    // Jika inbox dibuka, tandai notifikasi sebagai sudah dibaca
    if (!inboxMenu.classList.contains("hidden")) {
        // Endpoint API ini perlu Anda buat untuk menandai semua notifikasi sebagai dibaca
        try {
            await axios.post("/api/notifikasi/baca-semua");
            inboxBadge.classList.add("hidden"); // Langsung sembunyikan badge
        } catch (error) {
            console.error("Gagal menandai notifikasi sebagai dibaca:", error);
        }
    }
});

fetchNotifications();
