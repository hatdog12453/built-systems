import './bootstrap';

import { createApp } from 'vue';
import FlashMessages from './components/FlashMessages.vue';
import AdminDashboardStats from './components/AdminDashboardStats.vue';
import CoachDashboardStats from './components/CoachDashboardStats.vue';
import ClientDashboardStats from './components/ClientDashboardStats.vue';
import HomeHeroStats from './components/HomeHeroStats.vue';
import RegisterHeader from './components/RegisterHeader.vue';
import PaymentClientInfo from './components/PaymentClientInfo.vue';
import LoginHeader from './components/LoginHeader.vue';
import ServiceModal from './components/ServiceModal.vue';
import HomeAboutSection from './components/HomeAboutSection.vue';
import HomeProgramsSection from './components/HomeProgramsSection.vue';
import HomeSuccessStoriesSection from './components/HomeSuccessStoriesSection.vue';
import HomeServicesSection from './components/HomeServicesSection.vue';
import HomeCoachesSection from './components/HomeCoachesSection.vue';
import HomeCTASection from './components/HomeCTASection.vue';
import AdminPaymentNotifications from './components/AdminPaymentNotifications.vue';
import AdminExpiringSubscriptions from './components/AdminExpiringSubscriptions.vue';
import AdminPaymentsTable from './components/AdminPaymentsTable.vue';
import AdminClientsTable from './components/AdminClientsTable.vue';
import AdminCoachesTable from './components/AdminCoachesTable.vue';
import CoachClientCards from './components/CoachClientCards.vue';
import ClientPlansContent from './components/ClientPlansContent.vue';
import ForgotPasswordForm from './components/ForgotPasswordForm.vue';
import VerifyCodeForm from './components/VerifyCodeForm.vue';
import ResetPasswordForm from './components/ResetPasswordForm.vue';

// Global flash message component (all pages)
const flashRoot = document.getElementById('flash-messages-root');

if (flashRoot) {
    const success = flashRoot.dataset.success || '';
    const error = flashRoot.dataset.error || '';

    createApp(FlashMessages, {
        success,
        error,
    }).mount(flashRoot);
}

// Admin dashboard stats component (admin dashboard only)
const adminStatsRoot = document.getElementById('admin-dashboard-root');

if (adminStatsRoot) {
    const totalClients = Number(adminStatsRoot.dataset.totalClients || 0);
    const totalCoaches = Number(adminStatsRoot.dataset.totalCoaches || 0);
    const pendingPayments = Number(adminStatsRoot.dataset.pendingPayments || 0);
    const activeClients = Number(adminStatsRoot.dataset.activeClients || 0);
    const expiringSubscriptions = Number(adminStatsRoot.dataset.expiringSubscriptions || 0);

    createApp(AdminDashboardStats, {
        totalClients,
        totalCoaches,
        pendingPayments,
        activeClients,
        expiringSubscriptions,
    }).mount(adminStatsRoot);
}

// Coach dashboard stats (side nav buttons)
const coachStatsRoot = document.getElementById('coach-dashboard-stats-root');

if (coachStatsRoot) {
    const totalClients = Number(coachStatsRoot.dataset.totalClients || 0);
    const activeClients = Number(coachStatsRoot.dataset.activeClients || 0);
    const totalMealPlans = Number(coachStatsRoot.dataset.totalMealPlans || 0);
    const totalSessionPlans = Number(coachStatsRoot.dataset.totalSessionPlans || 0);

    createApp(CoachDashboardStats, {
        totalClients,
        activeClients,
        totalMealPlans,
        totalSessionPlans,
    }).mount(coachStatsRoot);
}

// Client dashboard stats (My Plans side nav buttons)
const clientStatsRoot = document.getElementById('client-dashboard-stats-root');

if (clientStatsRoot) {
    const mealPlansCount = Number(clientStatsRoot.dataset.mealPlansCount || 0);
    const sessionPlansCount = Number(clientStatsRoot.dataset.sessionPlansCount || 0);
    const progressCount = Number(clientStatsRoot.dataset.progressCount || 0);

    createApp(ClientDashboardStats, {
        mealPlansCount,
        sessionPlansCount,
        progressCount,
    }).mount(clientStatsRoot);
}

// Home page hero stats (landing page)
const homeHeroStatsRoot = document.getElementById('home-hero-stats-root');

if (homeHeroStatsRoot) {
    const activeClients = homeHeroStatsRoot.dataset.activeClients || '1000+';
    const expertCoaches = homeHeroStatsRoot.dataset.expertCoaches || '50+';
    const successRate = homeHeroStatsRoot.dataset.successRate || '95%';

    createApp(HomeHeroStats, {
        activeClients,
        expertCoaches,
        successRate,
    }).mount(homeHeroStatsRoot);
}

// Registration page header
const registerHeaderRoot = document.getElementById('register-header-root');

if (registerHeaderRoot) {
    createApp(RegisterHeader).mount(registerHeaderRoot);
}

// Payment page client info box
const paymentClientInfoRoot = document.getElementById('payment-client-info-root');

if (paymentClientInfoRoot) {
    const clientName = paymentClientInfoRoot.dataset.clientName || '';
    const clientEmail = paymentClientInfoRoot.dataset.clientEmail || '';
    const subscription = paymentClientInfoRoot.dataset.subscription || '';

    createApp(PaymentClientInfo, {
        clientName,
        clientEmail,
        subscription,
    }).mount(paymentClientInfoRoot);
}

// Login page header
const loginHeaderRoot = document.getElementById('login-header-root');

if (loginHeaderRoot) {
    createApp(LoginHeader).mount(loginHeaderRoot);
}

// Service modal (home page)
const serviceModalRoot = document.getElementById('service-modal-root');

if (serviceModalRoot) {
    const registerUrl = serviceModalRoot.dataset.registerUrl || '/register';

    createApp(ServiceModal, {
        registerUrl,
    }).mount(serviceModalRoot);
}

// Home page sections (landing page)
const homeAboutRoot = document.getElementById('home-about-root');
if (homeAboutRoot) {
    createApp(HomeAboutSection).mount(homeAboutRoot);
}

const homeProgramsRoot = document.getElementById('home-programs-root');
if (homeProgramsRoot) {
    createApp(HomeProgramsSection).mount(homeProgramsRoot);
}

const homeSuccessRoot = document.getElementById('home-success-root');
if (homeSuccessRoot) {
    createApp(HomeSuccessStoriesSection).mount(homeSuccessRoot);
}

const homeServicesRoot = document.getElementById('home-services-root');
if (homeServicesRoot) {
    createApp(HomeServicesSection).mount(homeServicesRoot);
}

const homeCoachesRoot = document.getElementById('home-coaches-root');
if (homeCoachesRoot) {
    const coachesJson = homeCoachesRoot.dataset.coaches || '[]';
    const coaches = JSON.parse(coachesJson);
    const registerUrl = homeCoachesRoot.dataset.registerUrl || '/register';

    createApp(HomeCoachesSection, {
        coaches,
        registerUrl,
    }).mount(homeCoachesRoot);
}

const homeCTARoot = document.getElementById('home-cta-root');
if (homeCTARoot) {
    const registerUrl = homeCTARoot.dataset.registerUrl || '/register';

    createApp(HomeCTASection, {
        registerUrl,
    }).mount(homeCTARoot);
}

// Admin dashboard components
const adminPaymentNotificationsRoot = document.getElementById('admin-payment-notifications-root');
if (adminPaymentNotificationsRoot) {
    const paymentsJson = adminPaymentNotificationsRoot.dataset.payments || '[]';
    const payments = JSON.parse(paymentsJson);

    createApp(AdminPaymentNotifications, {
        payments,
    }).mount(adminPaymentNotificationsRoot);
}

const adminExpiringSubscriptionsRoot = document.getElementById('admin-expiring-subscriptions-root');
if (adminExpiringSubscriptionsRoot) {
    const clientsJson = adminExpiringSubscriptionsRoot.dataset.clients || '[]';
    const clients = JSON.parse(clientsJson);
    const csrfToken = adminExpiringSubscriptionsRoot.dataset.csrfToken || '';
    const sendReminderRoute = adminExpiringSubscriptionsRoot.dataset.sendReminderRoute || '';

    createApp(AdminExpiringSubscriptions, {
        clients,
        csrfToken,
        sendReminderRoute,
    }).mount(adminExpiringSubscriptionsRoot);
}

const adminPaymentsTableRoot = document.getElementById('admin-payments-table-root');
if (adminPaymentsTableRoot) {
    const paymentsJson = adminPaymentsTableRoot.dataset.payments || '[]';
    const payments = JSON.parse(paymentsJson);
    const csrfToken = adminPaymentsTableRoot.dataset.csrfToken || '';
    const updateStatusRoute = adminPaymentsTableRoot.dataset.updateStatusRoute || '';
    const paginationHtml = adminPaymentsTableRoot.dataset.paginationHtml || '';

    createApp(AdminPaymentsTable, {
        payments,
        csrfToken,
        updateStatusRoute,
        paginationHtml,
    }).mount(adminPaymentsTableRoot);
}

const adminClientsTableRoot = document.getElementById('admin-clients-table-root');
if (adminClientsTableRoot) {
    const clientsJson = adminClientsTableRoot.dataset.clients || '[]';
    const clients = JSON.parse(clientsJson);
    const csrfToken = adminClientsTableRoot.dataset.csrfToken || '';
    const updateStatusRoute = adminClientsTableRoot.dataset.updateStatusRoute || '';
    const editRoute = adminClientsTableRoot.dataset.editRoute || '';
    const deleteRoute = adminClientsTableRoot.dataset.deleteRoute || '';
    const paginationHtml = adminClientsTableRoot.dataset.paginationHtml || '';

    createApp(AdminClientsTable, {
        clients,
        csrfToken,
        updateStatusRoute,
        editRoute,
        deleteRoute,
        paginationHtml,
    }).mount(adminClientsTableRoot);
}

const adminCoachesTableRoot = document.getElementById('admin-coaches-table-root');
if (adminCoachesTableRoot) {
    const coachesJson = adminCoachesTableRoot.dataset.coaches || '[]';
    const coaches = JSON.parse(coachesJson);
    const csrfToken = adminCoachesTableRoot.dataset.csrfToken || '';
    const editRoute = adminCoachesTableRoot.dataset.editRoute || '';
    const deleteRoute = adminCoachesTableRoot.dataset.deleteRoute || '';
    const paginationHtml = adminCoachesTableRoot.dataset.paginationHtml || '';

    createApp(AdminCoachesTable, {
        coaches,
        csrfToken,
        editRoute,
        deleteRoute,
        paginationHtml,
    }).mount(adminCoachesTableRoot);
}

// Coach dashboard client cards
const coachClientCardsRoot = document.getElementById('coach-client-cards-root');
if (coachClientCardsRoot) {
    const clientsJson = coachClientCardsRoot.dataset.clients || '[]';
    const clients = JSON.parse(clientsJson);

    createApp(CoachClientCards, {
        clients,
    }).mount(coachClientCardsRoot);
}

// Client dashboard plans content
const clientPlansContentRoot = document.getElementById('client-plans-content-root');
if (clientPlansContentRoot) {
    const mealPlansJson = clientPlansContentRoot.dataset.mealPlans || '[]';
    const sessionPlansJson = clientPlansContentRoot.dataset.sessionPlans || '[]';
    const progressTrackersJson = clientPlansContentRoot.dataset.progressTrackers || '[]';
    
    const mealPlans = JSON.parse(mealPlansJson);
    const sessionPlans = JSON.parse(sessionPlansJson);
    const progressTrackers = JSON.parse(progressTrackersJson);

    createApp(ClientPlansContent, {
        mealPlans,
        sessionPlans,
        progressTrackers,
    }).mount(clientPlansContentRoot);
}

// Auth pages
const forgotPasswordFormRoot = document.getElementById('forgot-password-form-root');
if (forgotPasswordFormRoot) {
    const csrfToken = forgotPasswordFormRoot.dataset.csrfToken || '';
    const submitUrl = forgotPasswordFormRoot.dataset.submitUrl || '';
    const loginUrl = forgotPasswordFormRoot.dataset.loginUrl || '/login';
    const initialEmail = forgotPasswordFormRoot.dataset.initialEmail || '';
    const initialRole = forgotPasswordFormRoot.dataset.initialRole || '';
    const errorMessage = forgotPasswordFormRoot.dataset.errorMessage || '';

    createApp(ForgotPasswordForm, {
        csrfToken,
        submitUrl,
        loginUrl,
        initialEmail,
        initialRole,
        errorMessage,
    }).mount(forgotPasswordFormRoot);
}

const verifyCodeFormRoot = document.getElementById('verify-code-form-root');
if (verifyCodeFormRoot) {
    const csrfToken = verifyCodeFormRoot.dataset.csrfToken || '';
    const submitUrl = verifyCodeFormRoot.dataset.submitUrl || '';
    const forgotPasswordUrl = verifyCodeFormRoot.dataset.forgotPasswordUrl || '/forgot-password';
    const email = verifyCodeFormRoot.dataset.email || '';
    const errorMessage = verifyCodeFormRoot.dataset.errorMessage || '';
    const successMessage = verifyCodeFormRoot.dataset.successMessage || '';

    createApp(VerifyCodeForm, {
        csrfToken,
        submitUrl,
        forgotPasswordUrl,
        email,
        errorMessage,
        successMessage,
    }).mount(verifyCodeFormRoot);
}

const resetPasswordFormRoot = document.getElementById('reset-password-form-root');
if (resetPasswordFormRoot) {
    const csrfToken = resetPasswordFormRoot.dataset.csrfToken || '';
    const submitUrl = resetPasswordFormRoot.dataset.submitUrl || '';
    const loginUrl = resetPasswordFormRoot.dataset.loginUrl || '/login';
    const email = resetPasswordFormRoot.dataset.email || '';
    const errorMessage = resetPasswordFormRoot.dataset.errorMessage || '';

    createApp(ResetPasswordForm, {
        csrfToken,
        submitUrl,
        loginUrl,
        email,
        errorMessage,
    }).mount(resetPasswordFormRoot);
}
