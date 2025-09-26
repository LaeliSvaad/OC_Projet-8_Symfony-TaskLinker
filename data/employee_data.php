<?php
use App\Enum\EmployeeContract;

return [
    ["firstname" => "Alice", "lastname" => "Durand", "email" => "alice@example.com", "contract" => EmployeeContract::CDD, "arrival_date" => new \DateTime('-1 month')],
    ["firstname" => "René", "lastname" => "Lataupe", "email" => "rene@example.com", "contract" => EmployeeContract::Freelance, "arrival_date" => new \DateTime('-1 year')],
    ["firstname" => "Pierrot", "lastname" => "Lefou", "email" => "pierrot@example.com", "contract" => EmployeeContract::CDI, "arrival_date" => new \DateTime('-1 week')],
    ["firstname" => "Jeanine", "lastname" => "Pascal", "email" => "jeanine@example.com", "contract" => EmployeeContract::CDD, "arrival_date" => new \DateTime('now')]
];
