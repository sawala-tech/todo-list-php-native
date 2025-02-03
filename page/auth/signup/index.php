<?php
require_once __DIR__ . '/../../../helpers.php';
include components('templates/header');

$success = false;
?>

<div class="flex items-center justify-center w-full h-screen">
    <div class="flex flex-col items-center justify-center w-full bg-white rounded-xl p-9 space-y-11 max-w-[500px]">
        <img src="<?= assets("images/logo.png") ?>" alt="logo" class="w-[261.29px] h-[58px]" />
        <form class="flex-col items-center justify-center w-full space-y-6 <?= $success ? 'hidden' : 'flex' ?>">
            <h1 class="text-3xl font-semibold">Buat Akun</h1>
            <div class="flex flex-col space-y-1.5 w-full">
                <label for="username" class="text-sm font-semibold">Username <span class="text-red-500">*</span></label>
                <input type="text" id="username" name="username" class="w-full h-12 px-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" required />
            </div>
            <div class="flex flex-col space-y-1.5 w-full">
                <label for="password" class="text-sm font-semibold">Password <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password" id="password" name="password" class="w-full h-12 px-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500" required />
                    <button type="button" class="absolute z-40 transform -translate-y-1/2 cursor-pointer top-1/2 right-4" id="cta-show-hide-password">
                        <img src="<?= assets("images/icons/open-eye.svg") ?>" alt="open-eye-image" class="hidden w-6 h-6" id="open-eye">
                        <img src="<?= assets("images/icons/close-eye.svg") ?>" alt="close-eye-image" class="block w-6 h-6" id="close-eye">
                    </button>
                </div>
            </div>
            <button class="flex items-center justify-center w-full h-12 px-2 overflow-hidden rounded-md bg-emerald-500 hover:bg-emerald-700" type="submit">
                <p class="text-base font-semibold leading-snug text-center text-white">Buat Akun</d>
            </button>
            <div class="flex items-center justify-center w-full space-x-2">
                <p class="text-sm">Sudah punya akun?</p>
                <a href="<?= url('auth/signin') ?>" class="text-sm font-semibold text-emerald-500 hover:underline">Masuk</a>
            </div>
        </form>

        <div class="flex flex-col items-center justify-center w-full space-y-11 <?= $success ? 'flex' : 'hidden' ?>">
            <img src="<?= assets("images/icons/success.svg") ?>" alt="success-icon" class="w-16 h-w-16" />
            <div class="flex flex-col w-full space-y-6 text-center">
                <h1 class="text-3xl font-semibold">Akun berhasil dibuat!</h1>
                <a href="<?= url('auth/signin') ?>" class="w-full">
                    <button class="flex items-center justify-center w-full h-12 px-2 overflow-hidden rounded-md bg-emerald-500 hover:bg-emerald-700" type="submit">
                        <p class="text-base font-semibold leading-snug text-center text-white">Masuk</d>
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<?php include components('templates/footer'); ?>