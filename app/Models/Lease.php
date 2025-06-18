<?php

namespace App\Models;

use App\Models\LeaseDocument;
use App\Models\LeaseTermEffectiveDate;
use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    protected $fillable = [
        'tenant_id',
        'property_id',
        'property_type',
        'guarantor',
    ];

    public function leaseEndDetails()
    {
        return $this->hasOne(LeaseEndDetail::class);
    }

    public function rentAutomationSettings()
    {
        return $this->hasOne(RentAutomationSetting::class);
    }

    public function leaseDocuments()
    {
        return $this->hasOne(LeaseDocument::class);
    }

    public function leaseSpecificClauses()
    {
        return $this->hasOne(LeaseSpecificClause::class);
    }

    public function rentRevisionConditions()
    {
        return $this->hasOne(RentRevisionCondition::class);
    }

    public function serviceChargeConditions()
    {
        return $this->hasOne(ServiceChargeCondition::class);
    }

    public function leaseFinancialConditions()
    {
        return $this->hasOne(LeaseFinancialCondition::class);
    }

    public function leaseTermEffectiveDates()
    {
        return $this->hasOne(LeaseTermEffectiveDate::class);
    }
}
