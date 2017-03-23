<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/************************************
 * USER FRIENDLY URL FOR FREELANCER
 ************************************/
$route['win-jobs']       = 'win_jobs';
$route['ended-jobs']     = 'ended_jobs';


/****************************************
 * USER FRIENDLY URL FOR CLIENT/EMPLOYER
 ****************************************/
$route['jobs/my-freelancers']  = 'job/my_freelancers'; 
$route['jobs/past-hires']      = 'job/past_hires';
$route['jobs/offers-sent']     = 'job/offers_sent';
$route['jobs/my-contracts']    = 'job/my_contracts';
$route['jobs/ended-contracts'] = 'job/ended_contracts';
$route['jobs/work-diary']      = 'job/work_diary';


$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['app'] = 'app/index';
$route['app/(:any)'] = 'app/index/';
$route['materia'] = 'materia/index';
$route['materia/(:any)'] = 'materia/index';



$route['administrator'] = 'administrator/home';
$route['post-job'] = 'jobs/create';
$route['find-jobs'] = 'jobs/find';
$route['find-jobs/(:any)'] = 'jobs/find/($1)';
$route['find-jobs/(:any)/(:any)'] = 'jobs/find/($1)/($2)';
$route['jobs-home'] = 'jobs/status';
$route['payment-methods'] = 'payment/methods';
$route['payment-methods/remove'] = 'payment/removeAccount';
$route['payment-methods/add-account'] = 'payment/addPaymentMethodAcc';
$route['payment/tax-information'] = 'payment/taxInformation';
$route['payment/tax-information-save'] = 'payment/updateTaxInformation';
$route['profile-settings'] = 'profilesetting';
$route['administrator/(:any)'] = 'administrator/$1';
$route['profile/update-basic-profile'] = "profile/updateBasicProfile";
$route['profile/update-portfolio'] = "profile/updatePortfolio";
$route['profile/my-freelancer-profile'] = "profile/freelancerProfile";
$route['profile/update-contact-details'] = "profile/updateContactDetails";
$route['profile/remove-portfolio'] = "profile/removePortfolio";
$route['profile/edit-portfolio'] = "profile/editPortfolio";
$route['profile/find-freelancer'] = "profile/searchFreelancer";
$route['search'] = "search";
$route['homepage'] = "home/homepage";
$route['json/(:any)'] = 'json/(:any)';

$route['contract/ended'] = 'jobs/ended_contract';
$route['contract/restart'] = 'jobs/restart';
$route['contract/paused'] = 'jobs/paused';
$route['notifications/contracts'] = 'jobs/notifications';
$route['contracts'] = 'jobs/contracts';


$route['profile/manageaccount'] = "profile/manageaccount";
$route['profile/basic'] = "profile/basic";
$route['profile/addedu'] = "profile/addedu";
$route['profile/add_education'] = "profile/add_education";
$route['profile/basic_bio'] = "profile/basic_bio";
$route['profile/add-exp'] = "profile/addExp";
$route['profile/search-freelancer'] = 'profile/searchFreelancer';
$route['profile/basic-profile-page'] = 'profile/basicProfilePage';
$route['profile/add_experience'] = 'profile/add_experience';
$route['profile/edit-portfolio'] = 'profile/editPortfolio';
$route['profile/edit-exp-profile'] = 'profile/editExpProfile';
$route['profile/remove-portfolio'] = 'profile/removePortfolio';
$route['profile/do-upload'] = 'profile/doUpload';
$route['profile/freelancer-profile'] = 'profile/freelancerProfile';
$route['profile/profile_freelancer'] = 'profile/profile_freelancer';

$route['profile/remove-edu/(:num)'] = 'profile/removeEdu/$1';
$route['profile/remove-exp/(:num)'] = 'profile/removeExp/$1';
$route['profile/remove-edu/(:num)/(:any)'] = 'profile/removeEdu/$1/$2';
$route['profile/remove-exp/(:num)/(:any)'] = 'profile/removeExp/$1/$2';

$route['profile/(:any)'] = 'profile/index/($1)';

//Routes for Footer
$route['add-fund'] = 'footerPages/add_fund';
$route['cancellation-refund'] = 'footerPages/cancellation';
$route['desktop-app'] = 'footerPages/desktop_app';
$route['enterprise-solution'] = 'footerPages/enterprise';
$route['fees-charges'] = 'footerPages/fees';
$route['getwork-done'] = 'footerPages/getwork_done';

//added by Ralfh 3/23/2017
$route['employer-help'] = 'footerPages/employer_help';
$route['freelancer-help'] = 'footerPages/freelancer_help';

$route['employer-help/registering-account'] = 'footerPages/registering_account';
$route['employer-help/costs-to-use'] = 'footerPages/costs_to_use';
$route['employer-help/understanding-account-settings'] = 'footerPages/understanding_account_settings';
$route['employer-help/verified-payments'] = 'footerPages/verified_payments';

$route['employer-help/posting-jobs'] = 'footerPages/posting_jobs';
$route['employer-help/jobs-description'] = 'footerPages/jobs_description';
$route['employer-help/featuring-jobs'] = 'footerPages/featuring_jobs';
$route['employer-help/job-status'] = 'footerPages/job_status';
$route['employer-help/posting-restrictions'] = 'footerPages/posting_restrictions';

$route['employer-help/finding-freelancers'] = 'footerPages/finding_freelancers';
$route['employer-help/viewing-quotes'] = 'footerPages/viewing_quotes';
$route['employer-help/awarding-job'] = 'footerPages/awarding_job';
$route['employer-help/deciding-agreement'] = 'footerPages/deciding_agreement';


$route['employer-help/communicating-with-freelancers'] = 'footerPages/communicating_with_freelancers';
$route['employer-help/adding-files'] = 'footerPages/adding_files';
$route['employer-help/managing-team'] = 'footerPages/managing_team';
$route['employer-help/understanding-time-tracker'] = 'footerPages/understanding_time_tracker';
$route['employer-help/understanding-workroom'] = 'footerPages/understanding_workroom';
//end

$route['how-to-join'] = 'footerPages/join';
$route['make-better'] = 'footerPages/make_better';
$route['press'] = 'footerPages/press';
$route['create-ticket'] = 'footerPages/create_ticket';
$route['trust-safety'] = 'footerPages/trust_safety';
$route['feedback'] = 'footerPages/feedback';

$route['freelance-jobs'] = 'jobs/jobs_no_auth';
$route['freelance-jobs/(:any)'] = 'jobs/jobs_no_auth/($1)';
$route['freelance-jobs/(:any)/(:any)'] = 'jobs/jobs_no_auth/($1)/($2)';