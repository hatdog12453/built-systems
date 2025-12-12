/**
 * Shared utility functions for Vue components
 * Consolidates duplicate code across components
 */

/**
 * Format a date string to a readable format
 * @param {string} dateString - ISO date string
 * @returns {string} Formatted date string
 */
export function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

/**
 * Format an amount to currency format
 * @param {number|string} amount - Amount to format
 * @returns {string} Formatted amount string
 */
export function formatAmount(amount) {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(amount);
}

/**
 * Get CSS classes for status badges
 * @param {string} status - Status value
 * @param {string} type - Type of status ('payment', 'client', 'session', 'default')
 * @returns {string} CSS classes for status badge
 */
export function getStatusClass(status, type = 'default') {
    if (type === 'payment') {
        if (status === 'paid') return 'bg-green-100 text-green-800';
        if (status === 'pending') return 'bg-yellow-100 text-yellow-800';
        return 'bg-red-100 text-red-800';
    }
    
    if (type === 'client') {
        if (status === 'active') return 'bg-green-100 text-green-800';
        if (status === 'pending') return 'bg-yellow-100 text-yellow-800';
        return 'bg-red-100 text-red-800';
    }
    
    if (type === 'session') {
        if (status === 'completed') return 'bg-green-100 text-green-800';
        if (status === 'scheduled') return 'bg-blue-100 text-blue-800';
        return 'bg-yellow-100 text-yellow-800';
    }
    
    // Default status classes
    if (status === 'active' || status === 'paid' || status === 'completed') return 'bg-green-100 text-green-800';
    if (status === 'pending' || status === 'scheduled') return 'bg-yellow-100 text-yellow-800';
    return 'bg-red-100 text-red-800';
}

/**
 * Capitalize the first letter of a string
 * @param {string} str - String to capitalize
 * @returns {string} Capitalized string
 */
export function capitalize(str) {
    if (!str) return '';
    return str.charAt(0).toUpperCase() + str.slice(1);
}

/**
 * Get initials from a full name
 * @param {string} name - Full name
 * @returns {string} First letter of the name
 */
export function getInitials(name) {
    if (!name) return '';
    return name.substring(0, 1).toUpperCase();
}

/**
 * Format status string (replace underscores and capitalize)
 * @param {string} status - Status string
 * @returns {string} Formatted status string
 */
export function formatStatus(status) {
    if (!status) return '';
    return status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
}

/**
 * Format payment method name
 * @param {string} method - Payment method
 * @returns {string} Formatted method name
 */
export function formatMethod(method) {
    if (method === 'paymaya') return 'PayMaya';
    if (method === 'gcash') return 'GCash';
    if (method === 'bank') return 'Bank';
    return method ? method.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : '';
}

/**
 * Format meal type string
 * @param {string} type - Meal type
 * @returns {string} Formatted meal type
 */
export function formatMealType(type) {
    if (!type) return '';
    return type.replace(/_/g, ' ');
}

