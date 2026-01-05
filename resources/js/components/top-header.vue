<template>
    <header>
        <section class="top-header">
            <div class="d-flex justify-content-start align-items-center flex-wrap gap-3 gap-md-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-telephone-fill mt-1"></i>
                    {{ masterStore?.masterData?.footer_contact }}
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-envelope-fill mt-1"></i>
                    {{ masterStore?.masterData?.footer_email }}
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-center gap-3">
                <div class="language-select lang-1__dropdown position-relative">
                    <div class="selected-language">
                        <div class="d-flex align-items-center gap-2">
                            <div class="size-24">
                                <img src="https://lms.rocket-soft.org/vendor/blade-country-flags/4x3-us.svg"
                                    class="img-fluid" width="16px" height="16px" alt="English flag">
                            </div>
                            <span class="js-lang-title text-white opacity-75 d-none d-md-flex">
                                {{masterStore.masterData?.languages?.find(lang => lang.name ===
                                    localeStore.language)?.title ||
                                    localeStore.language}}
                            </span>
                            <svg width="16px" height="16px" class="icons text-white opacity-75"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                    stroke-width="1.5" d="M19.92 8.95l-6.52 6.52c-.77.77-2.03.77-2.8 0L4.08 8.95">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <div>
                        <div class="lang-1-dropdown-menu">

                            <div class="text-secondary m-0 py-1 px-0">{{ $t('Select Language') }}</div>

                            <div v-for="lang in masterStore.masterData?.languages" :key="lang"
                                class="language-dropdown-item lang-1-dropdown-menu__item cursor-pointer"
                                :class="{ 'active': lang.name === localeStore.language }" role="button" data-value="EN"
                                data-title="English" @click="modifyLang(lang.name)">
                                <div class=" d-flex align-items-center">
                                    <div class="lang-1-dropdown-menu__flag">
                                        <img src="https://lms.rocket-soft.org/vendor/blade-country-flags/4x3-us.svg"
                                            class="img-cover" alt="English flag">
                                    </div>
                                    <span class="ml-8 font-14">
                                        {{ lang.title }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="!authStore.authToken" class="d-flex justify-content-end align-items-center gap-2">
                    <router-link to="/login" class="login-btn">{{ $t('Login') }}</router-link>
                    <router-link to="/register" class="register-btn">{{ $t('Register') }}</router-link>
                </div>
            </div>

        </section>
    </header>
</template>

<style lang="css" scoped>
.top-header {
    width: 100%;
    background-color: var(--bs-primary);
    font-size: 14px;
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    padding: 5px 20px;
}

/* Container */
.language-select {
    position: relative;
    cursor: pointer;
    user-select: none;
    z-index: 99999;
}

/* Selected language button */
.selected-language {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 4px 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.selected-language:hover {
    background: rgba(255, 255, 255, 0.2);
}

/* Flag icon inside button */
.size-24 {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.size-24 img {
    width: 12px;
    height: 12px;
    object-fit: cover;
}

/* Arrow icon rotation on hover */
.selected-language svg {
    transition: transform 0.3s ease;
}

.language-select:hover .selected-language svg {
    transform: rotate(180deg);
}

/* Dropdown menu */
.lang-1-dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    width: 200px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
    z-index: 999;
    padding: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
}

/* Show dropdown on hover */
.language-select:hover .lang-1-dropdown-menu {
    display: flex;
}

/* Dropdown header */
.lang-1-dropdown-menu>div:first-child {
    font-size: 12px;
    color: #aaa;
    padding: 8px 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

/* Dropdown items */
.language-dropdown-item {
    display: flex;
    align-items: center;
    padding: 8px 16px;
    margin: 4px 0;
    transition: all 0.3s ease;
    border-radius: 8px;
}

.language-dropdown-item:hover {
    background: rgba(255, 255, 255, 0.1);
}

.language-dropdown-item:hover {
    background: var(--light-primary);
}

.language-dropdown-item.active {
    background: var(--bs-primary);
    color: #fff;
}

.language-dropdown-item.active span {
    color: #fff;
}

/* Flag inside dropdown */
.lang-1-dropdown-menu__flag {
    width: 20px;
    height: 14px;
    overflow: hidden;
    border-radius: 2px;
}

.lang-1-dropdown-menu__flag img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Text inside dropdown item */
.language-dropdown-item span {
    margin-left: 8px;
    font-size: 14px;
    font-weight: 500;
    color: #1e1e2f;
}

.login-btn,
.register-btn {
    background-color: var(--bs-primary);
    color: #fff;
    border-radius: 50px;
    font-weight: 500;
    transition: all 0.3s ease;
}

@media (max-width: 440px) {
    .lang-1-dropdown-menu {
        left: 0;
    }
}
</style>

<script setup>
import { ref, watch } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useMasterStore } from "@/stores/master";
import { useLocaleStore } from "../stores/locale";
import localization from "../localization";

const authStore = useAuthStore();
const masterStore = useMasterStore();
const localeStore = useLocaleStore();
let currentLanguage = ref('en');

watch(() => localeStore.language, (oldValue, newValue) => {
    if (oldValue !== newValue) {
        modifyLang(localeStore.language);
    }
});

const modifyLang = (lang) => {
    localeStore.setLang(lang);
    const language = masterStore.masterData.languages.find(lang => lang.name === localeStore.language);
    if (language) {
        localeStore.language = language.name;
    }
    localization.fetchLocalizationData();
};

</script>
