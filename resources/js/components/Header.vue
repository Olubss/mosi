<template>
    <topHeader/>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <router-link to="/" class="navbar-brand">
                <img :src="masterStore?.masterData?.logo" width="150px" height="50px" class="object-fit-contain"
                    alt="LMS-logo" />
            </router-link>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </button>

            <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link to="/" :class="['nav-link m-0 ', $route.path === '/' ? 'active' : '',]">
                            {{ $t('Home') }}
                        </router-link>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex align-items-center gap-2" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $t('Categories') }}
                            <i class="bi bi-chevron-down ms-1" style="font-size: 12px;"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li v-for="category in categories" :key="category.id">
                                <router-link :to="'/courses?category_id=' + category.id" class="dropdown-item d-flex align-items-center justify-content-center gap-2" href="#">
                                    <div class="position-relative">
                                        <img :src="category.image" class="me-3 rounded-circle" height="40px"
                                            width="40px" />
                                        <small class="category-badge">
                                            {{ category.course_count }}
                                        </small>
                                    </div>
                                    {{ category.title }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <router-link to="/courses"
                            :class="['nav-link m-0', $route.path === '/courses' ? 'active' : '',]">
                            {{ $t('Courses') }}
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/about-us"
                            :class="['nav-link m-0', $route.path === '/about-us' ? 'active' : '',]">
                            {{ $t('About Us') }}
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/contact-us"
                            :class="['nav-link m-0', $route.path === '/contact-us' ? 'active' : '',]">
                            {{ $t('Contact Us') }}
                        </router-link>
                    </li>
                    <li v-if="authStore.authToken" class="nav-item d-flex align-items-center justify-content-center ms-md-5">
                        <div class="d-flex align-items-center gap-3">
                            <!-- Profile Dropdown -->
                            <div class="dropdown">
                                <button class="btn d-flex align-items-center" type="button" id="profileDropdown"
                                    data-bs-toggle="dropdown">
                                    <img :src="authStore.userData.profile_picture" alt="Profile">
                                </button>
                                <div class="dropdown-menu dropdown-menu-end shadow-lg rounded-3"
                                    aria-labelledby="profileDropdown">
                                    <router-link to="/dashboard" class="dropdown-item d-flex align-items-center">
                                        {{ $t('Dashboard') }}
                                    </router-link>
                                    <router-link to="/dashboard/profile"
                                        class="dropdown-item d-flex align-items-center">
                                        {{ $t('Profile') }}
                                    </router-link>
                                    <router-link to="/dashboard/courses"
                                        class="dropdown-item d-flex align-items-center">
                                        {{ $t('Courses') }}
                                    </router-link>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item text-danger d-flex align-items-center" @click="logout()">
                                        <i class="bi bi-box-arrow-right mt-1"></i>
                                        {{ $t('Logout') }}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.navbar {
    transition: all 0.3s ease;
    align-items: center;
}

.navbar.sticky-top {
    background-color: #ffffff;
    /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08); */
}

/* Navbar brand */
.navbar-brand {
    font-weight: 700;
    font-size: 1.6rem;
    color: #563d7c;
    transition: color 0.3s;
}

.navbar-brand:hover {
    color: #b54dff;
}

/* Links */
.nav-link {
    font-size: 0.875rem;
    color: #555;
    font-weight: 500;
    margin: 0 5px;
    position: relative;
    transition: color 0.3s;
}

.nav-link::after {
    content: '';
    position: absolute;
    width: 0%;
    height: 3px;
    bottom: 0;
    left: 0;
    background-color: #b54dff;
    transition: width 0.3s;
}

.nav-link.active {
    color: #b54dff;
}

.nav-link.active::after {
    width: 100%;
}

.nav-link:hover::after {
    width: 100%;
}

.nav-link:hover {
    color: #b54dff;
}

.navbar-nav {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

/* Profile image */
.navbar .profile-img {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 8px;
}

/* Hamburger animation */
.navbar-toggler {
    border: none;
    outline: none;
}

.category-badge {
    position: absolute;
    top: -6px;
    right: 8px;
    background: var(--bs-primary);
    color: #fff;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 600;
}

@media (max-width: 991.98px) {

    /* Collapse container */
    #navbarContent {
        background: #fff;
        text-align: center;
        padding: 1rem;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        transform: translateY(-10px);
        opacity: 0;
        transition: all 0.4s ease-in-out;
    }

    /* When menu is shown */
    .collapse.show#navbarContent {
        transform: translateY(0);
        opacity: 1;
    }

    /* Nav */
    #navbarContent .navbar-nav {
        gap: 6px;
    }

    /* Nav item */
    #navbarContent .nav-item {
        width: 100%;
        margin-bottom: 0.2rem;
    }

    /* Nav link */
    #navbarContent .nav-link {
        display: block;
        padding: 12px 16px;
        font-size: 16px;
        font-weight: 500;
        color: #333;
        background: #fff;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    /* Hover effect with subtle animation */
    #navbarContent .nav-link:hover {
        background: rgba(255, 255, 255, 0.9);
        color: var(--bs-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* Active link */
    #navbarContent .nav-link.active {
        color: var(--bs-primary);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Ripple animation effect on click */
    #navbarContent .nav-link::after {
        width: 0;
    }

    #navbarContent .nav-link:active::after {
        width: 0;
    }
}
</style>

<script setup>
import topHeader from "./top-header.vue";
import { useAuthStore } from "@/stores/auth";
import { useMasterStore } from "@/stores/master";
import Swal from "sweetalert2";
import { ref, onMounted, onUnmounted, watch } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { useI18n } from "vue-i18n";

const router = useRouter();
const authStore = useAuthStore();
const masterStore = useMasterStore();
const isLoggedIn = ref(false);
const isScrolled = ref(false);
const { t } = useI18n();

const handleScroll = () => {
    isScrolled.value = window.scrollY > 0;
};

let categories = ref([]);

const fetchCategories = async () => {
    try {
        const response = await axios.get(`/categories`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            params: {
                items_per_page: 20,
                page_number: 1,
            },
        });
        categories.value = response.data.data.categories;
    } catch (error) {
        console.error("Error fetching categories:", error);
    }
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    fetchCategories();
    if (authStore.authToken) {
        isLoggedIn.value = true;
    }
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

function logout() {
    Swal.fire({
        title: t("Are you sure?"),
        text: t("Do you want to log out?"),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: t("Yes, log out!"),
        cancelButtonText: t("No"),
    }).then((result) => {
        if (result.isConfirmed) {
            authStore.clearAuthData();

            Swal.fire({
                title: t("Logged Out!"),
                text: t("Log out successful."),
                showConfirmButton: false,
                icon: "success",
                timer: 1500,
            });
        }
        router.push("/");
    });
}

</script>
