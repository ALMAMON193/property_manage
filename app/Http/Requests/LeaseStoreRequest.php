<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return [
            // leases table
            'tenant_id' => 'nullable|exists:tenants,id',
            'property_id' => 'nullable',
            'property_type' => 'nullable|string|max:255',
            'guarantor' => 'required|string|max:255',

            // lease_end_details table
            'lease_end_details.departure_date_of_the_tenant' => 'nullable|date',
            'lease_end_details.deposit_to_be_returned' => 'nullable|numeric|min:0',
            'lease_end_details.date_of_return_of_the_security_deposit' => 'nullable|date|after_or_equal:lease_end_details.departure_date_of_the_tenant',

            // rent_automation_settings table
            'rent_automation_settings.generate_rents_from_date' => 'nullable|date',
            'rent_automation_settings.tenant_balance' => 'nullable|numeric|min:0',
            'rent_automation_settings.automatic_rent_revision' => 'boolean',
            'rent_automation_settings.automatic_sending_of_rent_receipt' => 'boolean',
            'rent_automation_settings.automatic_sending_of_rent_call' => 'boolean',
            'rent_automation_settings.automatic_sending_of_first_reminder' => 'boolean',
            'rent_automation_settings.automatic_sending_of_second_reminder' => 'boolean',
            'rent_automation_settings.automatic_sending_of_third_reminder' => 'boolean',
            'rent_automation_settings.rent_call_sending_date' => 'nullable|date',
            'rent_automation_settings.first_unpaid_rent_reminder_sending_date' => 'nullable|date|after_or_equal:rent_automation_settings.rent_call_sending_date',
            'rent_automation_settings.first_unpaid_rent_reminder_days_after' => 'nullable|integer|min:1',
            'rent_automation_settings.second_unpaid_rent_reminder_sending_date' => 'nullable|date|after_or_equal:rent_automation_settings.first_unpaid_rent_reminder_sending_date',
            'rent_automation_settings.second_unpaid_rent_reminder_days_after' => 'nullable|integer|min:1',
            'rent_automation_settings.third_unpaid_rent_reminder_sending_date' => 'nullable|date|after_or_equal:rent_automation_settings.second_unpaid_rent_reminder_sending_date',
            'rent_automation_settings.third_unpaid_rent_reminder_days_after' => 'nullable|integer|min:1',

            // lease_documents table
            'lease_documents.inventory_of_premises_annex' => 'nullable|string|max:255',
            'lease_documents.inventory_of_furnishings_annex' => 'nullable|string|max:255',
            'lease_documents.furniture_inventory_annex' => 'nullable|string|max:255',
            'lease_documents.co_ownership_regulations_annex' => 'nullable|string|max:255',
            'lease_documents.student_mobility_lease_justification_annex' => 'nullable|string|max:255',
            'lease_documents.specific_lease_justification_annex' => 'nullable|string|max:255',
            'lease_documents.technical_diagnostics_ddt_annex' => 'nullable|string|max:255',
            'lease_documents.landlords_bank_details_annex' => 'nullable|string|max:255',
            'lease_documents.other_lease_related_documents' => 'nullable|string|max:255',

            // lease_specific_clauses table
            'lease_specific_clauses.grounds_for_termination_clause' => 'nullable|string',
            'lease_specific_clauses.type_of_use_of_leased_property' => 'nullable|string|max:255',
            'lease_specific_clauses.key_money_amount' => 'nullable|numeric|min:0',
            'lease_specific_clauses.legal_qualification_key_money' => 'nullable|string|max:255',
            'lease_specific_clauses.value_of_lease_right' => 'nullable|numeric|min:0',
            'lease_specific_clauses.conditions_for_assignment_of_lease_right' => 'nullable|string',

            // rent_revision_conditions table
            'rent_revision_conditions.revision_frequency' => 'nullable|string|max:255',
            'rent_revision_conditions.date_of_last_revision' => 'nullable|date',
            'rent_revision_conditions.reference_index' => 'nullable|string|max:255',
            'rent_revision_conditions.other_index_to_specify' => 'nullable|string',
            'rent_revision_conditions.index_reference_quarter' => 'nullable|string|max:255',
            'rent_revision_conditions.index_reference_year' => 'nullable|string|max:255',
            'rent_revision_conditions.reference_index_value' => 'nullable|numeric|min:0',
            'rent_revision_conditions.revision_formula' => 'nullable|string',

            // service_charge_conditions table
            'service_charge_conditions.type_of_charges' => 'nullable|string|max:255',
            'service_charge_conditions.monthly_flat_rate_amount' => 'nullable|numeric|min:0',
            'service_charge_conditions.fixed_charges_included' => 'nullable|string',
            'service_charge_conditions.monthly_provision_for_actual_charges' => 'nullable|numeric|min:0',
            'service_charge_conditions.types_of_actual_charges' => 'nullable|string',
            'service_charge_conditions.procedures_for_regularization_of_actual_charges' => 'nullable|string',
            'service_charge_conditions.distribution_of_charges_between_co_tenants' => 'nullable|string',
            'service_charge_conditions.property_tax_allocation' => 'nullable|string|max:255',
            'service_charge_conditions.co_ownership_charges_allocation' => 'nullable|string|max:255',
            'service_charge_conditions.insurance_allocation' => 'nullable|string|max:255',
            'service_charge_conditions.maintenance_repairs_allocation' => 'nullable|string|max:255',
            'service_charge_conditions.taxes_and_fees_allocation' => 'nullable|string|max:255',
            'service_charge_conditions.other_property_tax_allocation' => 'nullable|string',
            'service_charge_conditions.other_co_ownership_charges_allocation' => 'nullable|string',
            'service_charge_conditions.other_insurance_allocation' => 'nullable|string',
            'service_charge_conditions.other_maintenance_repairs_allocation' => 'nullable|string',
            'service_charge_conditions.other_taxes_and_fees_allocation' => 'nullable|string',
            'service_charge_conditions.security_deposit' => 'nullable|numeric|min:0',

            // lease_financial_conditions table
            'lease_financial_conditions.rent_amount' => 'nullable|numeric|min:0',
            'lease_financial_conditions.rent_payment_due_date' => 'nullable|date',
            'lease_financial_conditions.rent_payment_frequency' => 'nullable|string|max:255',
            'lease_financial_conditions.preferred_rent_payment_method' => 'nullable|string|max:255',
            'lease_financial_conditions.other_accepted_payment_methods' => 'nullable|string',

            // lease_term_effective_dates table
            'lease_term_effective_dates.lease_type' => ['nullable', 'string', 'max:255'],
            'lease_term_effective_dates.furnished_lease_term_type' => 'nullable|string|max:255',
            'lease_term_effective_dates.furnished_lease_duration' => 'nullable|integer|min:1',
            'lease_term_effective_dates.unfurnished_lease_term_type' => 'nullable|string|max:255',
            'lease_term_effective_dates.unfurnished_lease_duration' => 'nullable|integer|min:1',
            'lease_term_effective_dates.commercial_lease_term_type' => 'nullable|string|max:255',
            'lease_term_effective_dates.commercial_lease_duration' => 'nullable|integer|min:1',
            'lease_term_effective_dates.professional_lease_term_type' => 'nullable|string|max:255',
            'lease_term_effective_dates.professional_lease_duration' => 'nullable|integer|min:1',
            'lease_term_effective_dates.lease_signing_date' => 'nullable|date',
            'lease_term_effective_dates.lease_effective_date' => 'nullable|date|after_or_equal:lease_term_effective_dates.lease_signing_date',
            'lease_term_effective_dates.lease_renewal_extension_conditions' => 'nullable|string',
            'lease_term_effective_dates.lease_removal_conditions' => 'nullable|string',
        ];
    }
}
