<template>
    <div class="d-flex">
        <div class="bg-primary-orange vh-100 w-25 d-lg-block d-none"></div>
        <div class="m-auto col-sm-4  mt-xs-4">
            <div>
                <slot name="logo" />
            </div>

            <div class="py-4 w-full">
                <slot />
            </div>
        </div>
    </div>
</template>
