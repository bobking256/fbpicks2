<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-nfl-navy-800">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="h-1.5 bg-nfl-red-500"></div>
            <div class="px-6 py-4">
                <slot />
            </div>
        </div>
    </div>
</template>
