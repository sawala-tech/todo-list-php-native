<?php
$currentPath = $_SERVER['REQUEST_URI'];
$hideNavbar = false;

if (strpos($currentPath, 'auth') !== false) {
    $hideNavbar = true;
}
?>

<div class="items-center justify-between bg-white px-[26px] py-[27px] fixed top-0 w-full z-40 <?= $hideNavbar ? 'hidden' : 'flex' ?>">
    <a href="<?= url('dashboard') ?>">
        <img src="<?= assets('images/logo.png') ?>" alt="logo" class="h-[46px] w-[208.96px]">
    </a>
    <div class="flex items-center space-x-5">
        <div>
            <button class="flex items-center justify-center px-5 py-3 space-x-1 text-white bg-green-500 rounded-lg hover:bg-green-700">
                <img src="<?= assets('images/icons/plus.svg') ?>" alt="plus" class="w-6 h-6" />
                <span class="font-semibold">Tambah Tugas</span>
            </button>
        </div>
        <div class="flex items-center space-x-1">
            <img src="<?= assets('images/icons/user.svg') ?>" alt="user" class="w-6 h-6" />
            <p class="font-semibold truncate max-w-48">
                Halo, Hamdan Nurachid
            </p>
        </div>
        <div class="w-px h-8 bg-gray-400"></div>
        <div>
            <a class="font-semibold text-red-500 cursor-pointer hover:text-red-700">Keluar</a>
        </div>
    </div>
</div>