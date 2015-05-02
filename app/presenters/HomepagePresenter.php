<?php

namespace Cake;

use Cake\Controls\Form;
use LeanMapper\Exception\Exception;
use Nette;
use Nette\Application\UI;
use Cake\Model\ThingRepository;
use Cake\Model\Thing;

class HomepagePresenter extends UI\Presenter
{
	/** @var ThingRepository @inject */
	public $thingRepository;

	public function renderDefault()
	{
		$this->template->thing = $this->thingRepository->findRnd();
		$this->template->thingsCount = $this->thingRepository->countAll();
	}


	public function createComponentAddItem()
	{
		$form = new Form();

		$form->addText('thing', 'Sem vlož prostě normální slovo:')
			->setRequired();

		$form->addProtection('Bezpečnostní tekken vypršel, nelze odeslat formulář');
		$form->addSubmit('submit', 'Přidat slovo');

		$form->onSuccess[] = $this->addItemSuccessSubmited;
		return $form;
	}


	public function addItemSuccessSubmited(Form $form)
	{
		$val = $form->getValues();

		try{
			$this->thingRepository->persist(Thing::from($val));
			$this->presenter->flashMessage('Prostě normální slovo bylo vloženo do databáze', 'success');
			$this->redirect('this');
		}catch (Exception $e){
			$this->presenter->flashMessage($e->getMessage(), 'error');
		}catch(\DibiDriverException $e){
			$this->presenter->flashMessage($e->getMessage(), 'error');
		}
	}
}
