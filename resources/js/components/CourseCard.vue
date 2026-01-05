<template>
    <div class="course-card h-100">

        <div class="card border-light theme-shadow overflow-hidden h-100">
            <router-link :to="'/details/' + course.id" class="course-thumbnail-wrapper position-relative">
                <img :src="course.thumbnail" class="course-thumbnail card-img-top object-fit-cover" alt="..." />
                <div class="category-badge">
                    <strong>{{ course.category }}</strong>
                </div>
            </router-link>
            <div class="card-body pb-0">
                <div class="course-details-wrapper">
                    <!-- Lessons -->
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-mortarboard"></i>
                        <span>{{ course.chapter_count }} {{ $t("Classes") }}</span>
                    </div>

                    <!-- Duration -->
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock text-warning"></i>
                        <span>{{ formatDuration(course?.total_duration) }}</span>
                    </div>
                </div>

                <div class="header-metadata">
                    <router-link :to="`/details/${course.id}`" class="text-decoration-none d-block mb-2">
                        <p class="course-title fw-bold text-hover">
                            {{ shortText(course.title) }}
                        </p>
                    </router-link>
                </div>
                <div
                    class="card-text text-muted d-flex flex-column flex-xl-row gap-2 justify-content-between mb-3 mt-3 mt-md-0">
                    <!-- Price -->
                    <div v-if="!course?.is_free && !course?.is_enrolled" class="d-flex align-items-center">
                        <strong class="text-primary me-2">
                            <span v-if="masterStore?.masterData?.currency_position == 'Left'" class="fs-4">
                                {{ masterStore?.masterData?.currency_symbol }}{{ course.price ?? course.regular_price }}
                            </span>
                            <span v-else class="fs-4">
                                {{ course.price ?? course.regular_price }}{{ masterStore?.masterData?.currency_symbol }}
                            </span>
                        </strong>

                        <!-- Show regular price if discounted -->
                        <span v-if="course?.price" class="text-muted text-decoration-line-through">
                            <span v-if="masterStore?.masterData?.currency_position == 'Left'" style="font-size: 14px;">
                                {{ masterStore?.masterData?.currency_symbol }}{{ course.regular_price }}
                            </span>
                            <span v-else style="font-size: 14px;">
                                {{ course.regular_price }}{{ masterStore?.masterData?.currency_symbol }}
                            </span>
                        </span>
                    </div>

                    <!-- Free / Enrolled Badge -->
                    <div v-else class="d-flex w-100 align-self-center me-auto my-auto mt-1">
                        <span class="badge px-3 py-2 rounded fw-semibold"
                            :class="course?.is_enrolled ? 'bg-primary text-white' : 'bg-light text-primary border border-primary'"
                            style="font-size: 13px;">
                            {{ course?.is_enrolled ? $t("Enrolled") : $t("Free") }}
                        </span>
                    </div>

                </div>

            </div>
            <div class="card-footer bg-white border-light py-0">
                <div class="row">
                    <div class="col-12 text-muted course-metadata py-2">
                        <router-link :to="'/instructor/' + course.instructor.id"
                            class="d-flex align-items-center gap-2 text-decoration-none text-muted">
                            <img :src="course.instructor.profile_picture" alt="instructor-avatar" width="35" height="35"
                                class="rounded-circle object-fit-cover">
                            <span class="fw-bold">{{ shortName(course.instructor?.name) }}</span>
                        </router-link>
                        <span class="order-md-1 order-xl-2">
                            <i class="bi bi-star-fill me-2 text-warning"></i>
                            <strong>{{ course.average_rating }}

                            </strong>
                            ({{ course.review_count }})
                        </span>
                    </div>
                    <!-- <div class="col-12 col-sm-6 my-auto">
                        <router-link :to="`/details/${course.id}`"
                            class="small text-decoration-none text-dark d-flex justify-content-start justify-content-md-end align-items-center gap-2 py-3 py-md-0">
                            {{ $t('Details') }}
                            <i class="bi bi-chevron-right goto-details-icon rounded-circle px-1 text-muted"></i>
                        </router-link>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.header-metadata {
    height: 50px;
    overflow: hidden;
    margin-bottom: 5px;
}

.course-metadata {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    color: #64748B !important;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 20px;
}

.course-title {
    overflow: hidden;
    color: #0F172A;
    font-family: Lexend;
    font-size: 16px;
    font-style: normal;
    font-weight: 500;
    line-height: 24px;
}

.goto-details-icon {
    background-color: #eee;
}

.course-card {
    transition: all 0.4s ease-out;

    .course-thumbnail-wrapper {
        height: 200px;
        overflow: hidden;

        .course-thumbnail {
            object-fit: cover;
            width: 100%;
            height: 100%;
            transition: transform 0.2s ease-out;
        }
    }

    .border-light {
        border-color: #eee !important;
    }

    &:hover {
        .border-light {
            transition: all 0.5s ease-in;
            border-color: #ddd !important;
        }

        .course-thumbnail {
            transform: scale(1.1);
        }
    }
}

.category-badge {
    position: absolute;
    top: 0px;
    left: 0px;
    background-color: var(--bg-primary);
    color: #fff;
    padding: 4px 10px;
    border-bottom-right-radius: 5px;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.course-details-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    font-size: 14px;
    font-weight: 600;
    color: var(--bg-primary);
    margin-bottom: 10px;
}

@media (max-width: 576px) {
    .card-body {
        padding: 0.5rem 0.5rem;
    }

    .card-footer {
        padding: 0.5rem 0.5rem;
    }

    .header-metadata {
        height: 75px;
    }

    .course-metadata {
        border-right: none;
        border-bottom: 1px solid #eaeaea;
        border-top: 1px solid #eaeaea;
    }
}
</style>

<script setup>
// import useMasterStore from ''
import { useMasterStore } from "@/stores/master";

const masterStore = useMasterStore();

// const masterData = masterStore.masterData

const props = defineProps({
    course: Object,
});

function shortText(text) {
    const width = window.innerWidth;
    const maxLength = width <= 576 ? 20 : 60;
    return text.length > maxLength ? text.slice(0, maxLength) + "..." : text;
}

const shortName = (name) => {
    if (!name) return '';
    const names = name.split(' ');
    if (names.length === 1) return names[0];
    return names[0] + ' ' + names[names.length - 1];
};

// works on time formating

const formatDuration = (duration) => {
    if (duration >= 60) {
        const hours = Math.floor(duration / 60);
        const minutes = duration % 60;
        return `${hours} hour${hours > 1 ? "s" : ""}${minutes > 0 ? ` ${minutes} min` : ""
            }`;
    }
    return `${duration} min`;
};
</script>
