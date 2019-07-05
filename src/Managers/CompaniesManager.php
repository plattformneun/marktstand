<?php

namespace Marktstand\Managers;

use Marktstand\Company\Company;

class CompaniesManager extends Manager
{
    /**
     * Create a new company.
     *
     * @param array $data
     * @param Illuminate\Foundation\Auth\User $user
     * @return Marktstand\Company\Company
     */
    public function create(array $data, $user)
    {
        $company = new Company;

        $this->makeFillable($company)->fill(array_merge($data, [
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
    public function update(Company $company, array $data)
    {
        $this->makeFillable($company)->update($data);

        return $company;
    }

    /**
     * Set the fillable fields.
     *
     * @return array
     */
    protected function fillable()
    {
        return [
            'name',
            'legal_form',
            'description',
            'street',
            'house',
            'post_code',
            'city',
            'country',
            'vat_id',
            'user_id',
            'user_type',
            'profile_image',
            'title_image',
        ];
    }
}
