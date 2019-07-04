<?php

namespace Marktstand\Managers;

use Marktstand\Company\Company;

trait CompaniesManager
{
    /**
     * Add a new company.
     *
     * @param Illuminate\Foundation\Auth\User $user
     * @param array $data
     * @return Marktstand\Company\Company
     */
    public function addCompany($user, array $data)
    {
        $company = new Company;

        $this->makeCompanyFillable($company)->fill(array_merge($data, [
            'user_id' => $user->id,
            'user_type' => $user->type,
        ]))->save();

        return $company;
    }

    /**
     * Update the given company.
     *
     * @param  Marktstand\Company\Company $company
     * @param  array $data
     * @return Marktstand\Company\Company
     */
    public function updateCompany(Company $company, array $data)
    {
        $this->makeCompanyFillable($company)
            ->update($data);

        return $company;
    }

    /**
     * Set fillable fields for the given company.
     *
     * @param  Marktstand\Company\Company $company
     * @return Marktstand\Company\Company
     */
    public function makeCompanyFillable(Company $company)
    {
        return $this->setFillable($company, [
            'name', 'legal_form', 'description', 'street', 'house', 'post_code', 'city', 'country', 'vat_id', 'user_id', 'user_type', 'profile_image', 'title_image',
        ]);
    }
}
