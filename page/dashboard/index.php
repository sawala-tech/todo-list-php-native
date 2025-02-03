<?php
require_once __DIR__ . '/../../helpers.php';
include components('templates/header');

$dataPopup = null;

$count = [
    'open' => 0,
    'in_progress' => 0,
    'done' => 0
];

$statuses = [
    'open' => ['title' => 'Open', 'color' => '#38B2AC', 'bg' => '#EBF8FF', 'icon' => 'sun.svg'],
    'in_progress' => ['title' => 'In Progress', 'color' => '#4299E1', 'bg' => '#F7FAFC', 'icon' => 'sync.svg'],
    'done' => ['title' => 'Done', 'color' => '#9F7AEA', 'bg' => '#EBF8FF', 'icon' => 'checked.svg']
];
?>

<main class="grid grid-cols-3 mt-[6.5rem]">
    <?php foreach ($statuses as $key => $status): ?>
        <div class="relative">
            <div class="flex items-center space-x-2" style="background-color: <?= $status['color'] ?>; padding: 1rem 1.5rem;">
                <img src="<?= assets('images/icons/' . $status['icon']) ?>" alt="icon" class="w-6 h-6" />
                <h3 class="text-lg font-semibold text-white"> <?= $status['title'] ?> </h3>
            </div>
            <div class="flex flex-col w-full h-[calc(100vh-11rem)]" style="background-color: <?= $status['bg'] ?>; <?= $count[$key] === 0 ? 'display: flex; align-items: center; justify-content: center;' : '' ?>">
                <?php if ($count[$key] === 0): ?>
                    <div class="flex flex-col items-center text-center text-[#A0AEC0]">
                        <img src="<?= assets('images/icons/edit.svg') ?>" alt="edit" class="w-20 h-20 mb-4" />
                        <h4 class="font-semibold">Belum ada tugas</h4>
                        <p>Segera tambahkan tugas baru kamu sekarang!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</main>

<?php include components('templates/footer'); ?>