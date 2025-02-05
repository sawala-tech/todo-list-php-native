<?php
require_once __DIR__ . '/../../helpers.php';
require_once __DIR__ . '/../../assets/php/functions.php';
include components('templates/header');

checkLogin('auth/signin');

$tasks = getTasks();

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'];
    deleteTask($id);
}

//check if http method is post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];
    $attachment = $_FILES['attachment'];
    $status = $_POST['status'];

    if(addTask($title, $description, $deadline, $attachment, $status)){
        header('Location: ' . url('dashboard'));
    }else{
        echo "<script>alert('Gagal menambahkan tugas')</script>";
    }
}

// Task Statuses & Initial Count
$statuses = [
    'open' => ['title' => 'Open', 'color' => 'bg-teal-500', 'bg' => 'bg-blue-100', 'icon' => 'sun.svg'],
    'in_progress' => ['title' => 'In Progress', 'color' => 'bg-blue-500', 'bg' => 'bg-gray-100', 'icon' => 'sync.svg'],
    'done' => ['title' => 'Done', 'color' => 'bg-purple-500', 'bg' => 'bg-blue-100', 'icon' => 'checked.svg']
];

// Count tasks per status
$taskCount = array_fill_keys(array_keys($statuses), 0);
foreach ($tasks as $task) {
    $taskCount[$task['status']]++;
}

?>

<main class="mt-[6.4rem]">
    <!-- Filter -->
    <div class="grid grid-cols-3 max-sm:gap-x-4">
        <?php foreach ($statuses as $key => $status): ?>
            <div class="flex items-center space-x-2 text-white md:px-6 md:py-4 max-sm:rounded-full pr-[12.5px] p-2 max-sm:w-fit max-sm:mx-auto <?= $status['color'] ?>" id="filterTodoTrigger" data-type="<?= $key ?>">
                <img src="<?= assets('images/icons/' . $status['icon']) ?>" alt="icon" class="w-5 h-5 md:w-6 md:h-6" />
                <h3 class="text-sm font-semibold md:text-lg"><?= $status['title'] ?> <span class="max-sm:hidden">(<?= $taskCount[$key] ?>)</span></h3>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Task List -->
    <div class="grid grid-cols-3">
        <?php foreach ($statuses as $key => $status): ?>
            <div class="flex flex-col h-full min-h-[calc(100vh-11rem)] space-y-4 p-4 max-sm:col-span-3 md:<?= $status['bg'] ?>" id="todoListWrapper" data-type="<?= $key ?>">
                <?php if ($taskCount[$key] === 0): ?>
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center h-full text-center text-gray-400">
                        <img src="<?= assets('images/icons/edit.svg') ?>" alt="edit" class="w-20 h-20 mb-4" />
                        <h4 class="font-semibold">Belum ada tugas</h4>
                        <p class="max-sm:max-w-72">Segera tambahkan tugas baru kamu sekarang!</p>
                    </div>
                <?php else: ?>
                    <!-- Task Cards -->
                    <?php foreach ($tasks as $task): ?>
                        <?php if ($task['status'] === $key): ?>
                            <div class="flex flex-col w-full p-4 space-y-5 bg-white rounded-lg shadow-md">
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
                                    <button
                                        id="deleteTodoTrigger"
                                        class=" text-[#E53E3E] font-semibold hover:text-red-700"
                                        data-id="<?= htmlspecialchars($task['id']); ?>"
                                        data-title="<?= htmlspecialchars($task['title']); ?>"
                                        data-description="<?= htmlspecialchars($task['description']); ?>"
                                        data-attachment="<?= htmlspecialchars($task['attachment']); ?>"
                                        data-deadline="<?= htmlspecialchars($task['deadline']); ?>">
                                        Hapus
                                    </button>
                                    <div class="w-px h-full bg-[#CBD5E0]"></div>
                                    <button
                                        id="editTodoTrigger"
                                        class=" text-[#3182CE] font-semibold hover:text-blue-700"
                                        data-id="<?= htmlspecialchars($task['id']); ?>"
                                        data-title="<?= htmlspecialchars($task['title']); ?>"
                                        data-description="<?= htmlspecialchars($task['description']); ?>"
                                        data-attachment="<?= htmlspecialchars($task['attachment']); ?>"
                                        data-deadline="<?= htmlspecialchars($task['deadline']); ?>">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Add/Edit Todo Modal -->
    <div id="addTodoModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-gray-900 bg-opacity-50">
        <div class="w-full md:max-w-[650px] p-6 bg-white rounded-2xl shadow-lg flex flex-col space-y-6 max-sm:mx-4">
            <h2 class="mb-2 text-xl font-bold">Tugas Baru</h2>
            <form class="flex flex-col space-y-4" action="<?= url('dashboard') ?>" method="POST" enctype="multipart/form-data">
                <div class="flex gap-2 md:items-center max-sm:flex-col">
                    <label class="text-sm font-semibold md:w-1/4">Nama Tugas</label>
                    <input type="text" class="md:w-3/4 h-10 px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Judul Tugas"  name="title" />
                </div>
                <div class="flex gap-2 md:items-center max-sm:flex-col">
                    <label class="text-sm font-semibold md:w-1/4">Deskripsi</label>
                    <textarea class="md:w-3/4 min-h-20 px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Deskripsi Tugas" name="description"></textarea>
                </div>
                <div class="flex gap-2 md:items-center max-sm:flex-col">
                    <label class="text-sm font-semibold md:w-1/4">Tenggat Waktu</label>
                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="md:w-3/4 h-10 px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer" placeholder="Pilih Tanggal" name="deadline" />
                </div>
                <div class="flex gap-2 md:items-center max-sm:flex-col">
                    <label class="text-sm font-semibold md:w-1/4">Lampiran/File</label>
                    <input type="file" class="md:w-3/4 h-10py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" name="attachment" />
                </div>
                <div class="flex gap-2 md:items-center max-sm:flex-col">
                    <label class="md:w-1/4">Status</label>
                    <select class="md:w-3/4 h-10 px-3 py-2.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm" name="status">
                        <option value="open">Open</option>
                        <option value="in_progress">In Progress</option>
                        <option value="done">Done</option>
                    </select>
                </div>


                <div class="grid grid-cols-2 gap-4">
                    <button class="px-4 py-2 mt-4 text-white rounded-md bg-emerald-500 hover:bg-emerald-700">Simpan</button>
                    <button id="closeAddTodoModal" class="px-4 py-2 mt-4 text-black bg-white border border-gray-400 rounded-md hover:bg-gray-100" type="button">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Todo Modal -->
    <div id="deleteTodoModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-gray-900 bg-opacity-50">
        <div class="w-full md:max-w-[650px] p-6 bg-white rounded-2xl shadow-lg flex flex-col space-y-6 max-sm:mx-4">
            <h2 class="mb-2 text-xl font-bold">Hapus Tugas</h2>
            <p class="text-gray-600">Apakah Anda yakin ingin menghapus tugas ini?</p>
            <div class="flex flex-col p-4 space-y-2 shadow rounded-xl">
                <h4 class="font-semibold" id="modal-title"></h4>
                <p class="text-gray-600 line-clamp-2" id="modal-description"></p>
                <div class="flex items-center gap-2">
                    <img src="<?= assets('images/icons/files.svg') ?>" alt="files" class="w-5 h-5" />
                    <a id="modal-attachment" href="#" target="_blank" class="text-blue-500 truncate hover:underline max-sm:max-w-60"></a>
                </div>
                <div class="flex items-center gap-2">
                    <img src="<?= assets('images/icons/clock.svg') ?>" alt="clock" class="w-5 h-5" />
                    <p id="modal-deadline"></p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <button class="px-4 py-2 mt-4 text-white bg-red-500 rounded-md hover:bg-red-700" onclick="deleteTask()">Ya, Hapus</button>
                <button id="closeDeleteTodoModal" class="px-4 py-2 mt-4 text-black bg-white border border-gray-400 rounded-md hover:bg-gray-100" type="button">Batal</button>
            </div>
        </div>
    </div>
</main>

<script>
    function deleteTask() {
        const id = document.getElementById('deleteTodoTrigger').dataset.id;
        fetch(`<?= url('dashboard') ?>?id=${id}`, {
            method: 'DELETE'
        }).then(() => {
            window.location.reload();
        });
    }
</script>

<?php include components('templates/footer'); ?>