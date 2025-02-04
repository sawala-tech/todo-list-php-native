<?php
require_once __DIR__ . '/../../helpers.php';
include components('templates/header');

// Task Statuses & Initial Count
$statuses = [
    'open' => ['title' => 'Open', 'color' => 'bg-teal-500', 'bg' => 'bg-blue-100', 'icon' => 'sun.svg'],
    'in_progress' => ['title' => 'In Progress', 'color' => 'bg-blue-500', 'bg' => 'bg-gray-100', 'icon' => 'sync.svg'],
    'done' => ['title' => 'Done', 'color' => 'bg-purple-500', 'bg' => 'bg-blue-100', 'icon' => 'checked.svg']
];

// Task Data
$tasks = [
    [
        "title" => "Tugas 1 : Belajar HTML",
        "description" => "Buat contoh struktur HTML sederhana untuk pembuatan aplikasi web",
        "deadline" => "2021-08-20",
        "status" => "open",
        "attachment" => "https://pdfobject.com/pdf/sample.pdf",
    ],
    [
        "title" => "Tugas 2 : Belajar CSS",
        "description" => "Buat contoh styling CSS sederhana untuk pembuatan aplikasi web",
        "deadline" => "2021-08-21",
        "status" => "open",
        "attachment" => "https://pdfobject.com/pdf/sample.pdf",
    ],
    [
        "title" => "Tugas 3 : Belajar JavaScript",
        "description" => "Buat contoh interaksi JavaScript sederhana untuk pembuatan aplikasi web",
        "deadline" => "2021-08-22",
        "status" => "done",
        "attachment" => "https://pdfobject.com/pdf/sample.pdf",
    ],
];

// Count tasks per status
$taskCount = array_fill_keys(array_keys($statuses), 0);
foreach ($tasks as $task) {
    $taskCount[$task['status']]++;
}

?>

<main class="grid grid-cols-3 mt-24">
    <?php foreach ($statuses as $key => $status): ?>
        <div class="relative">
            <!-- Header -->
            <div class="flex items-center space-x-2 text-white px-6 py-4 rounded-t-lg <?= $status['color'] ?>">
                <img src="<?= assets('images/icons/' . $status['icon']) ?>" alt="icon" class="w-6 h-6" />
                <h3 class="text-lg font-semibold"> <?= $status['title'] ?> (<?= $taskCount[$key] ?>) </h3>
            </div>

            <!-- Task List -->
            <div class="flex flex-col h-full min-h-[calc(100vh-11rem)] space-y-4 p-4 <?= $status['bg'] ?>">
                <?php if ($taskCount[$key] === 0): ?>
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center h-full text-center text-gray-400">
                        <img src="<?= assets('images/icons/edit.svg') ?>" alt="edit" class="w-20 h-20 mb-4" />
                        <h4 class="font-semibold">Belum ada tugas</h4>
                        <p>Segera tambahkan tugas baru kamu sekarang!</p>
                    </div>
                <?php else: ?>
                    <!-- Task Cards -->
                    <?php foreach ($tasks as $task): ?>
                        <?php if ($task['status'] === $key): ?>
                            <div class="flex flex-col p-4 space-y-5 bg-white rounded-lg shadow-md">
                                <div class="flex flex-col space-y-2">
                                    <h4 class="font-semibold"><?= htmlspecialchars($task['title']) ?></h4>
                                    <p class="text-gray-600 line-clamp-2"><?= htmlspecialchars($task['description']) ?></p>
                                    <div class="flex items-center space-x-2">
                                        <img src="<?= assets('images/icons/files.svg') ?>" alt="files" class="w-5 h-5" />
                                        <a href="<?= htmlspecialchars($task['attachment']) ?>" target="_blank" class="text-blue-500 hover:underline">
                                            <?= basename($task['attachment']) ?>
                                        </a>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <img src="<?= assets('images/icons/clock.svg') ?>" alt="clock" class="w-5 h-5" />
                                        <p>Tenggat Waktu: <?= date("d M Y", strtotime($task['deadline'])) ?></p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="text-[#E53E3E] font-semibold hover:text-red-700">Hapus</button>
                                    <div class="w-px h-full bg-[#CBD5E0]"></div>
                                    <button class="text-[#3182CE] font-semibold hover:text-blue-700">Edit</button>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</main>

<?php include components('templates/footer'); ?>