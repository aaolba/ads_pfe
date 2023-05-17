import Pagination from '@mui/material/Pagination';
import Stack from '@mui/material/Stack';

const Paginations=(props) =>{
  // const [page, setPage] =useState(1);
  const handleChange = (event, value) => {
    props.setpage(value);
  };

  return (
    <Stack  marginTop={7} marginBottom={5} spacing={2} alignItems='center'>
      <Pagination  count={props.nPages} page={props.page} onChange={handleChange} />
    </Stack>
  );
}
export default Paginations;