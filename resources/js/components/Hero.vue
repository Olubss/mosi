<template>
    <section class="pb-3 pb-lg-0 mb-5 position-relative mt-0">
        <section class="hero">
            <div class="container">
                <div class="row p-3 p-lg-5">
                <div class="col-lg-7 col-xxl-8  text-center text-lg-start my-auto pb-5 mb-lg-auto">
                    <span class="bg-white px-3 py-2 text-primary fw-bold rounded-pill">{{ masterStore?.masterData?.hero_subtitle ?? $t('Hi Learners') }}</span>
                    <h2 class="fw-bold my-3 my-md-4 hero-title">
                        {{ masterStore?.masterData?.hero_title ?? $t('Discover Your Perfect Learning Path') }}
                    </h2>

                    <span class="d-block mb-4 mx-auto mx-lg-0 hero-subtitle">
                        {{ masterStore?.masterData?.hero_description ?? $t('Hand-picked Instructor and expertly crafted courses designed for the modern students and entrepreneurs') }}.
                    </span>
                    <div class=" mx-auto mx-lg-0 col-12 col-md-8 col-xl-8">
                        <form @submit.prevent="performSearch" class="input-group" role="search">
                            <input v-model="searchInputQuery" class="form-control search-input border-0 search-input"
                                type="search" :placeholder="$t('Search Course')" />
                            <div class="bg-white search-btn-wrapper">
                                <button type="submit" class="btn btn-primary text-white border-3 border-white py-2">
                                    <i class="ri-search-2-line fs-4"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 col-xxl-4 pt-0 pt-md-0 pb-5">
                    <div class="position-relative d-flex justify-content-center align-items-center">
                            <img :src="masterStore?.masterData?.hero_thumbnail ?? '/assets/website/banner-hero.png'" loading="lazy" class="img-fluid hero-illustration"
                            :alt="$t('Hero Illustration')" />
                    </div>
                </div>
            </div>
            </div>
        </section>
        <div class="details-section py-2">
    <div class="container">
        <div class="row text-center">
            <!-- Item 1 -->
            <div class="col-6 col-md-4 mb-3">
                <div class="stat-box">
                    <i class="bi bi-award icon"></i>
                    <h3 class="number">{{ masterStore?.masterData?.total_courses }}+</h3>
                    <p class="label">Total Premium Courses</p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="col-6 col-md-4 mb-3">
                <div class="stat-box">
                    <i class="bi bi-mortarboard icon"></i>
                    <h3 class="number">{{ masterStore?.masterData?.total_enrollments }}+</h3>
                    <p class="label">Total Enrolled Students</p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="col-6 col-md-4 mb-3">
                <div class="stat-box">
                    <i class="bi bi-person-video3 icon"></i>
                    <h3 class="number">{{ masterStore?.masterData?.total_instructors }}+</h3>
                    <p class="label">Top Rated Instructor</p>
                </div>
            </div>
        </div>
    </div>
</div>

    </section>
</template>

<style scoped lang="scss">
.hero {
    width: 1580px;
    margin: 0 auto;
    background: url('/assets/website/hero-background.jpg') no-repeat center;
    background-size: cover;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
    border-bottom-left-radius: 100px;
    border-bottom-right-radius: 100px;
    .search-input {
        border-top-left-radius: 50px;
        border-bottom-left-radius: 50px;

        &::placeholder {
            color: #868686;
        }
    }

    .search-btn-wrapper {
        border-top-right-radius: 50px;
        border-bottom-right-radius: 50px;

        button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    }

    .animate-student {
        animation: studentAnimation 5s ease-in-out infinite;
    }

    @keyframes studentAnimation {
        0% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-20px);
        }

        100% {
            transform: translateY(0);
        }
    }
}

.hero-title {
    width: 80%;
    font-size: 64px;
    color: #ffffff;
}

.hero-subtitle {
    width: 70%;
    color: #ffffff;
    font-size: 14px;
}

.hero-illustration{
    position: relative;
    z-index: 1;
    box-sizing: border-box;
}

.details-section {
    position: absolute;
    width: 1400px;
    left: 50%;
    transform: translateX(-50%);
    bottom: -70px;
    z-index: 2;
    background: #ffffff;
    border-radius: 150px;
    box-shadow: 0 0 20px 10px rgba(95, 45, 237, 0.05);
}

.stat-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.stat-box .icon {
    font-size: 30px;
    color: var(--bs-primary); /* pink/red color */
}

.stat-box .number {
    font-size: 22px;
    font-weight: bold;
    margin: 0;
    color: #000;
}

.stat-box .label {
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    margin: 0;
    color: #555;
}

@media (max-width: 1600px) {
    .hero {
        width: 95%;
    }
    .details-section {
        width: 85%;
    }
}

@media (max-width: 1400px) {
    .hero {
        width: 100%;
    }
    .details-section {
        width: 90%;
    }
    .hero-title {
        width: 100%;
        font-size: 52px;
    }
}

@media (max-width: 1200px) {
    .details-section {
        width: 85%;
    }
    .hero-title {
        width: 100%;
        font-size: 44px;
    }

    .hero-subtitle {
        width: 80%;
    }
}

@media (max-width: 1024px) {
    .hero {
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
        border-bottom-left-radius: 60px;
        border-bottom-right-radius: 60px;
    }
    .details-section {
        width: 90%;
    }
    .hero-subtitle {
        width: 80%;
    }

    .hero-img{
        width: 100%;
    }
}

@media (max-width: 992px) {
    .hero {
        padding-top: 80px;
    }
}

@media (max-width: 768px) {
    .hero {
        padding-top: 60px;
        border-radius: 0px;
    }
    .details-section {
        width: 95%;
        border-radius: 8px;
    }
    .hero-title {
        font-size: 36px;
    }

    .hero-subtitle {
        width: 100%;
        font-size: 14px;
    }
}

@media (max-width: 576px) {
    .hero {
        padding-top: 40px;
    }
}

</style>

<script setup>
import { useRouter } from "vue-router";
import { ref } from "vue";
import { useMasterStore } from "@/stores/master";

const searchInputQuery = ref("");
const router = useRouter();
const masterStore = useMasterStore();

const isStudentSummaryAnimated = ref(true);
const isInstructorSummaryAnimated = ref(true);
const isCourseSummaryAnimated = ref(true);
const isReactionIllustrationAnimated = ref(true);

const performSearch = () => {
    if (searchInputQuery.value) {
        router.push(`/courses?search=${searchInputQuery.value}`);
    }
};
</script>
